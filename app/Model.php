<?php
namespace App;

use PDO;
use PDOException;


/**
 * BaseModel - ORM theo phong cách Eloquent cho PHP
 * 
 * Ví dụ sử dụng:
 * 
 * // Lấy tất cả bản ghi
 * Customer::all();
 * 
 * // Tìm theo khóa chính (ID)
 * Customer::find(1);
 * Customer::findOrFail(1);
 * 
 * // Query builder - Xây dựng truy vấn
 * Customer::where('status', 'active')->get();
 * Customer::where('age', '>', 18)->orderBy('name')->limit(10)->get();
 * Customer::where('email', 'test@example.com')->first();
 * 
 * // Thêm mới bản ghi
 * Customer::create(['name' => 'John', 'email' => 'john@example.com']);
 * 
 * // Cập nhật bản ghi
 * $customer = Customer::find(1);
 * $customer->update(['name' => 'Jane']);
 * // hoặc
 * Customer::where('id', 1)->update(['name' => 'Jane']);
 * 
 * // Xóa bản ghi
 * $customer = Customer::find(1);
 * $customer->delete();
 * // hoặc
 * Customer::where('status', 'inactive')->delete();
 * Customer::destroy(1);
 * Customer::destroy([1, 2, 3]);
 * 
 * // Phân trang
 * Customer::paginate(10);
 * Customer::where('status', 'active')->paginate(15);
 * 
 * // Đếm số lượng
 * Customer::count();
 * Customer::where('status', 'active')->count();
 */
class Model
{
    /**
     * Kết nối cơ sở dữ liệu (dùng chung cho tất cả instance)
     * @var PDO|null
     */
    protected static $connection = null;

    /**
     * Tên bảng trong database
     * Nếu không khai báo sẽ tự động đoán từ tên class (VD: Customer -> customers)
     * @var string
     */
    protected $table;

    /**
     * Tên cột khóa chính
     * Mặc định là 'id'
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Danh sách các cột được phép gán hàng loạt (mass assignment)
     * Để trống = cho phép tất cả trừ những cột trong $guarded
     * @var array
     */
    protected $fillable = [];

    /**
     * Danh sách các cột KHÔNG được phép gán hàng loạt
     * Bảo vệ các cột quan trọng như id, password...
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Bật/tắt tự động cập nhật created_at và updated_at
     * @var bool
     */
    protected $timestamps = true;

    /**
     * Lưu trữ các thuộc tính (dữ liệu) của model
     * @var array
     */
    protected $attributes = [];

    /**
     * Lưu trữ giá trị gốc để so sánh thay đổi
     * Dùng để kiểm tra xem có gì thay đổi không
     * @var array
     */
    protected $original = [];

    /**
     * Các thành phần của Query Builder
     */
    protected $wheres = [];           // Điều kiện WHERE
    protected $orders = [];           // Điều kiện ORDER BY
    protected $limitValue = null;     // Giá trị LIMIT
    protected $offsetValue = null;    // Giá trị OFFSET
    protected $selectColumns = ['*']; // Các cột cần SELECT
    protected $bindings = [];         // Giá trị binding cho prepared statement

    /**
     * Đánh dấu bản ghi đã tồn tại trong DB hay chưa
     * true = đã có trong DB (update), false = chưa có (insert)
     * @var bool
     */
    protected $exists = false;

    /**
     * Hàm khởi tạo Model
     * @param array $attributes Mảng thuộc tính ban đầu
     */
    public function __construct(array $attributes = [])
    {
        $this->bootIfNotBooted();
        $this->fill($attributes);
    }

    /**
     * Khởi tạo kết nối nếu chưa có
     * Chỉ kết nối 1 lần duy nhất cho tất cả Model
     */
    protected function bootIfNotBooted()
    {
        if (static::$connection === null) {
            $this->connect();
        }
    }

    /**
     * Thiết lập kết nối đến cơ sở dữ liệu MySQL
     * Sử dụng PDO với charset UTF-8
     */
    protected function connect()
    {
        try {
            static::$connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USERNAME,
                DB_PASSWORD
            );

            // Bật chế độ báo lỗi dạng Exception
            static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Đặt kiểu trả về mặc định là mảng liên kết
            static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    /**
     * Lấy đối tượng kết nối PDO
     * @return PDO
     */
    public static function getConnection()
    {
        $instance = new static();
        return static::$connection;
    }

    /**
     * Lấy tên bảng của Model
     * Nếu không khai báo $table, tự động đoán từ tên class
     * VD: Customer -> customers, Product -> products
     * @return string
     */
    public function getTable()
    {
        if ($this->table) {
            return $this->table;
        }

        // Tự động đoán tên bảng từ tên class
        $className = (new \ReflectionClass($this))->getShortName();
        return strtolower($className) . 's';
    }

    /**
     * Lấy tên cột khóa chính
     * @return string
     */
    public function getKeyName()
    {
        return $this->primaryKey;
    }

    /**
     * Lấy giá trị khóa chính của bản ghi hiện tại
     * @return mixed
     */
    public function getKey()
    {
        return $this->getAttribute($this->primaryKey);
    }

    // ==================== CÁC PHƯƠNG THỨC TĨNH (STATIC METHODS) ====================

    /**
     * Lấy tất cả bản ghi trong bảng
     * @param array|string $columns Các cột cần lấy, mặc định là tất cả
     * @return array Mảng các Model object
     * 
     * Ví dụ:
     * Customer::all();
     * Customer::all(['id', 'name', 'email']);
     */
    public static function all($columns = ['*'])
    {
        $instance = new static();
        $instance->selectColumns = is_array($columns) ? $columns : func_get_args();
        return $instance->get();
    }

    /**
     * Tìm bản ghi theo khóa chính (ID)
     * @param mixed $id Giá trị khóa chính
     * @param array $columns Các cột cần lấy
     * @return Model|null Trả về Model hoặc null nếu không tìm thấy
     * 
     * Ví dụ:
     * Customer::find(1);
     * Customer::find(1, ['id', 'name']);
     */
    public static function find($id, $columns = ['*'])
    {
        $instance = new static();
        $instance->selectColumns = is_array($columns) ? $columns : [$columns];
        return $instance->where($instance->primaryKey, '=', $id)->first();
    }

    /**
     * Tìm bản ghi theo khóa chính, ném Exception nếu không tìm thấy
     * @param mixed $id Giá trị khóa chính
     * @param array $columns Các cột cần lấy
     * @return Model
     * @throws \Exception Khi không tìm thấy bản ghi
     * 
     * Ví dụ:
     * Customer::findOrFail(1); // Ném exception nếu không có ID = 1
     */
    public static function findOrFail($id, $columns = ['*'])
    {
        $result = static::find($id, $columns);
        if (!$result) {
            throw new \Exception("Không tìm thấy bản ghi với ID: {$id}");
        }
        return $result;
    }

    /**
     * Tạo và lưu bản ghi mới vào database
     * @param array $attributes Mảng dữ liệu cần tạo
     * @return Model Instance của bản ghi vừa tạo
     * 
     * Ví dụ:
     * Customer::create([
     *     'ho_ten' => 'Nguyễn Văn A',
     *     'email' => 'a@example.com'
     * ]);
     */
    public static function create(array $attributes)
    {
        $instance = new static($attributes);
        $instance->save();
        return $instance;
    }

    /**
     * Xóa bản ghi theo khóa chính
     * Có thể xóa một hoặc nhiều bản ghi cùng lúc
     * @param mixed $ids ID hoặc mảng các ID cần xóa
     * @return int Số bản ghi đã xóa
     * 
     * Ví dụ:
     * Customer::destroy(1);           // Xóa 1 bản ghi
     * Customer::destroy([1, 2, 3]);   // Xóa nhiều bản ghi
     * Customer::destroy(1, 2, 3);     // Xóa nhiều bản ghi (cách khác)
     */
    public static function destroy($ids)
    {
        $ids = is_array($ids) ? $ids : func_get_args();
        $instance = new static();
        
        // Tạo các placeholder ? cho prepared statement
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM {$instance->getTable()} WHERE {$instance->primaryKey} IN ({$placeholders})";
        
        $stmt = static::$connection->prepare($sql);
        $stmt->execute($ids);
        
        return $stmt->rowCount();
    }

    /**
     * Bắt đầu một query mới (điểm vào tĩnh)
     * @return Model Instance mới của Model
     * 
     * Ví dụ:
     * Customer::query()->where('status', 1)->get();
     */
    public static function query()
    {
        return new static();
    }

    // ==================== QUERY BUILDER - XÂY DỰNG TRUY VẤN ====================

    /**
     * Thêm điều kiện WHERE
     * @param string $column Tên cột
     * @param mixed $operator Toán tử hoặc giá trị (nếu dùng 2 tham số)
     * @param mixed $value Giá trị so sánh
     * @return Model
     * 
     * Ví dụ:
     * Customer::where('status', 'active');           // status = 'active'
     * Customer::where('age', '>', 18);               // age > 18
     * Customer::where('name', 'LIKE', '%Nguyen%');   // name LIKE '%Nguyen%'
     */
    public static function where($column, $operator = null, $value = null)
    {
        $instance = new static();
        return $instance->addWhere($column, $operator, $value, 'AND');
    }

    /**
     * Thêm điều kiện OR WHERE
     * Dùng để kết hợp nhiều điều kiện với OR
     * @param string $column Tên cột
     * @param mixed $operator Toán tử hoặc giá trị
     * @param mixed $value Giá trị so sánh
     * @return Model
     * 
     * Ví dụ:
     * Customer::where('status', 'active')
     *          ->orWhere('vip', 1)
     *          ->get();
     * // WHERE status = 'active' OR vip = 1
     */
    public static function orWhere($column, $operator = null, $value = null)
    {
        $instance = new static();
        return $instance->addWhere($column, $operator, $value, 'OR');
    }

    /**
     * Phương thức nội bộ để thêm điều kiện WHERE
     * Xử lý cả 2 cú pháp: where('col', 'value') và where('col', '>', 'value')
     * @param string $column Tên cột
     * @param mixed $operator Toán tử
     * @param mixed $value Giá trị
     * @param string $boolean AND hoặc OR
     * @return Model
     */
    protected function addWhere($column, $operator = null, $value = null, $boolean = 'AND')
    {
        // Hỗ trợ cú pháp ngắn: where('column', 'value')
        // Tự động hiểu là where('column', '=', 'value')
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'boolean' => $boolean
        ];

        $this->bindings[] = $value;

        return $this;
    }

    /**
     * Thêm điều kiện WHERE IN
     * Tìm các bản ghi có giá trị nằm trong danh sách
     * @param string $column Tên cột
     * @param array $values Mảng các giá trị
     * @return Model
     * 
     * Ví dụ:
     * Customer::whereIn('id', [1, 2, 3])->get();
     * // WHERE id IN (1, 2, 3)
     */
    protected function _whereIn($column, array $values)
    {
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        
        $this->wheres[] = [
            'type' => 'In',
            'column' => $column,
            'values' => $values,
            'boolean' => 'AND'
        ];

        $this->bindings = array_merge($this->bindings, $values);

        return $this;
    }

    /**
     * Thêm điều kiện WHERE NOT IN
     * Tìm các bản ghi có giá trị KHÔNG nằm trong danh sách
     * @param string $column Tên cột
     * @param array $values Mảng các giá trị
     * @return Model
     * 
     * Ví dụ:
     * Customer::whereNotIn('status', ['banned', 'deleted'])->get();
     * // WHERE status NOT IN ('banned', 'deleted')
     */
    protected function _whereNotIn($column, array $values)
    {
        $this->wheres[] = [
            'type' => 'NotIn',
            'column' => $column,
            'values' => $values,
            'boolean' => 'AND'
        ];

        $this->bindings = array_merge($this->bindings, $values);

        return $this;
    }

    /**
     * Thêm điều kiện WHERE NULL
     * Tìm các bản ghi có giá trị NULL
     * @param string $column Tên cột
     * @return Model
     * 
     * Ví dụ:
     * Customer::whereNull('deleted_at')->get();
     * // WHERE deleted_at IS NULL
     */
    protected function _whereNull($column)
    {
        $this->wheres[] = [
            'type' => 'Null',
            'column' => $column,
            'boolean' => 'AND'
        ];

        return $this;
    }

    /**
     * Thêm điều kiện WHERE NOT NULL
     * Tìm các bản ghi có giá trị KHÔNG phải NULL
     * @param string $column Tên cột
     * @return Model
     * 
     * Ví dụ:
     * Customer::whereNotNull('email')->get();
     * // WHERE email IS NOT NULL
     */
    protected function _whereNotNull($column)
    {
        $this->wheres[] = [
            'type' => 'NotNull',
            'column' => $column,
            'boolean' => 'AND'
        ];

        return $this;
    }

    /**
     * Thêm điều kiện WHERE BETWEEN
     * Tìm các bản ghi có giá trị trong khoảng
     * @param string $column Tên cột
     * @param array $values Mảng 2 phần tử [min, max]
     * @return Model
     * 
     * Ví dụ:
     * Customer::whereBetween('age', [18, 30])->get();
     * // WHERE age BETWEEN 18 AND 30
     */
    protected function _whereBetween($column, array $values)
    {
        $this->wheres[] = [
            'type' => 'Between',
            'column' => $column,
            'values' => $values,
            'boolean' => 'AND'
        ];

        $this->bindings = array_merge($this->bindings, $values);

        return $this;
    }

    /**
     * Thêm điều kiện WHERE LIKE
     * Tìm kiếm theo pattern (hỗ trợ ký tự đại diện % và _)
     * @param string $column Tên cột
     * @param string $value Pattern tìm kiếm
     * @return Model
     * 
     * Ví dụ:
     * Customer::whereLike('name', '%Nguyen%')->get();
     * // WHERE name LIKE '%Nguyen%'
     */
    protected function _whereLike($column, $value)
    {
        return $this->addWhere($column, 'LIKE', $value, 'AND');
    }

    /**
     * Chọn các cột cần lấy
     * Ví dụ: Customer::select('id', 'name', 'email')->get();
     */
    protected function _select($columns = ['*'])
    {
        $this->selectColumns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * Thêm điều kiện sắp xếp ORDER BY
     * Ví dụ: Customer::orderBy('name', 'ASC')->get();
     */
    protected function _orderBy($column, $direction = 'ASC')
    {
        $this->orders[] = [
            'column' => $column,
            'direction' => strtoupper($direction)
        ];
        return $this;
    }

    /**
     * Sắp xếp giảm dần
     * Ví dụ: Customer::orderByDesc('id')->get();
     */
    protected function _orderByDesc($column)
    {
        return $this->_orderBy($column, 'DESC');
    }

    /**
     * Sắp xếp theo thời gian mới nhất (created_at DESC)
     * Ví dụ: Customer::latest()->get();
     */
    protected function _latest($column = 'created_at')
    {
        return $this->_orderBy($column, 'DESC');
    }

    /**
     * Sắp xếp theo thời gian cũ nhất (created_at ASC)
     * Ví dụ: Customer::oldest()->get();
     */
    protected function _oldest($column = 'created_at')
    {
        return $this->_orderBy($column, 'ASC');
    }

    /**
     * Giới hạn số lượng bản ghi trả về
     * Ví dụ: Customer::limit(10)->get();
     */
    protected function _limit($value)
    {
        $this->limitValue = $value;
        return $this;
    }

    /**
     * Alias cho limit()
     * Ví dụ: Customer::take(5)->get();
     */
    protected function _take($value)
    {
        return $this->_limit($value);
    }

    /**
     * Bỏ qua một số bản ghi đầu tiên
     * Ví dụ: Customer::offset(10)->limit(10)->get();
     */
    protected function _offset($value)
    {
        $this->offsetValue = $value;
        return $this;
    }

    /**
     * Alias cho offset()
     * Ví dụ: Customer::skip(20)->take(10)->get();
     */
    protected function _skip($value)
    {
        return $this->_offset($value);
    }

    // ==================== THỰC THI TRUY VẤN (EXECUTE QUERIES) ====================

    /**
     * Thực thi query và lấy tất cả kết quả
     * @param array $columns Các cột cần lấy (tùy chọn)
     * @return array Mảng các Model object
     * 
     * Ví dụ:
     * $customers = Customer::where('status', 1)->get();
     * foreach ($customers as $customer) {
     *     echo $customer->name;
     * }
     */
    public function get($columns = ['*'])
    {
        if ($columns !== ['*']) {
            $this->selectColumns = is_array($columns) ? $columns : func_get_args();
        }

        $sql = $this->buildSelectQuery();
        $stmt = static::$connection->prepare($sql);
        $stmt->execute($this->bindings);

        $results = [];
        while ($row = $stmt->fetch()) {
            $model = new static();
            $model->fill($row);
            $model->exists = true;      // Đánh dấu đã tồn tại trong DB
            $model->syncOriginal();     // Lưu giá trị gốc
            $results[] = $model;
        }

        return $results;
    }

    /**
     * Lấy bản ghi đầu tiên
     * @param array $columns Các cột cần lấy
     * @return Model|null Trả về Model hoặc null nếu không có
     * 
     * Ví dụ:
     * $customer = Customer::where('email', 'test@mail.com')->first();
     */
    public function first($columns = ['*'])
    {
        $this->limitValue = 1;
        $results = $this->get($columns);
        return count($results) > 0 ? $results[0] : null;
    }

    /**
     * Lấy bản ghi đầu tiên hoặc ném Exception
     * @param array $columns Các cột cần lấy
     * @return Model
     * @throws \Exception Khi không tìm thấy bản ghi
     * 
     * Ví dụ:
     * $customer = Customer::where('id', 999)->firstOrFail();
     */
    public function firstOrFail($columns = ['*'])
    {
        $result = $this->first($columns);
        if (!$result) {
            throw new \Exception("Không tìm thấy bản ghi nào");
        }
        return $result;
    }

    /**
     * Đếm số lượng bản ghi
     * @return int Số lượng bản ghi
     * 
     * Ví dụ:
     * $total = Customer::count();
     * $activeCount = Customer::where('status', 1)->count();
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) as aggregate FROM {$this->getTable()}";
        $sql .= $this->buildWhereClause();

        $stmt = static::$connection->prepare($sql);
        $stmt->execute($this->bindings);

        return (int) $stmt->fetch()['aggregate'];
    }

    /**
     * Kiểm tra có bản ghi nào tồn tại không
     * @return bool true nếu có ít nhất 1 bản ghi
     * 
     * Ví dụ:
     * if (Customer::where('email', 'test@mail.com')->exists()) {
     *     echo 'Email đã tồn tại';
     * }
     */
    public function exists()
    {
        return $this->count() > 0;
    }

    /**
     * Tính tổng giá trị của một cột
     * @param string $column Tên cột cần tính tổng
     * @return mixed Tổng giá trị
     * 
     * Ví dụ:
     * $totalRevenue = Order::sum('total_amount');
     */
    public function sum($column)
    {
        return $this->aggregate('SUM', $column);
    }

    /**
     * Tính giá trị trung bình của một cột
     * @param string $column Tên cột
     * @return mixed Giá trị trung bình
     * 
     * Ví dụ:
     * $avgAge = Customer::avg('age');
     */
    public function avg($column)
    {
        return $this->aggregate('AVG', $column);
    }

    /**
     * Lấy giá trị lớn nhất của một cột
     * @param string $column Tên cột
     * @return mixed Giá trị lớn nhất
     * 
     * Ví dụ:
     * $maxPrice = Product::max('price');
     */
    public function max($column)
    {
        return $this->aggregate('MAX', $column);
    }

    /**
     * Lấy giá trị nhỏ nhất của một cột
     * @param string $column Tên cột
     * @return mixed Giá trị nhỏ nhất
     * 
     * Ví dụ:
     * $minPrice = Product::min('price');
     */
    public function min($column)
    {
        return $this->aggregate('MIN', $column);
    }

    /**
     * Thực hiện hàm tổng hợp (aggregate function)
     * Phương thức nội bộ dùng cho sum, avg, max, min
     * @param string $function Tên hàm SQL (SUM, AVG, MAX, MIN)
     * @param string $column Tên cột
     * @return mixed Kết quả
     */
    protected function aggregate($function, $column)
    {
        $sql = "SELECT {$function}({$column}) as aggregate FROM {$this->getTable()}";
        $sql .= $this->buildWhereClause();

        $stmt = static::$connection->prepare($sql);
        $stmt->execute($this->bindings);

        return $stmt->fetch()['aggregate'];
    }

    /**
     * Phân trang kết quả
     * Tự động tính toán offset dựa trên trang hiện tại
     * @param int $perPage Số bản ghi mỗi trang
     * @param int|null $page Trang hiện tại (tự động lấy từ $_GET['page'] nếu không truyền)
     * @return array Mảng chứa dữ liệu và thông tin phân trang
     * 
     * Ví dụ:
     * $result = Customer::paginate(10);
     * // $result['data'] - Mảng các Model
     * // $result['current_page'] - Trang hiện tại
     * // $result['total'] - Tổng số bản ghi
     * // $result['last_page'] - Trang cuối cùng
     */
    public function paginate($perPage = 15, $page = null)
    {
        // Lấy trang hiện tại từ tham số hoặc từ URL (?page=2)
        $page = $page ?: (isset($_GET['page']) ? (int) $_GET['page'] : 1);
        $page = max(1, $page); // Đảm bảo trang >= 1

        // Đếm tổng số bản ghi
        $total = $this->count();
        // Tính số trang cuối cùng
        $lastPage = (int) ceil($total / $perPage);

        // Reset bindings cho query lấy dữ liệu
        $this->bindings = [];
        foreach ($this->wheres as $where) {
            if (isset($where['value'])) {
                $this->bindings[] = $where['value'];
            } elseif (isset($where['values'])) {
                $this->bindings = array_merge($this->bindings, $where['values']);
            }
        }

        // Thiết lập LIMIT và OFFSET
        $this->limitValue = $perPage;
        $this->offsetValue = ($page - 1) * $perPage;

        // Lấy dữ liệu
        $data = $this->get();

        // Trả về mảng với đầy đủ thông tin phân trang
        return [
            'data' => $data,                           // Dữ liệu trang hiện tại
            'current_page' => $page,                   // Trang hiện tại
            'per_page' => $perPage,                    // Số bản ghi mỗi trang
            'total' => $total,                         // Tổng số bản ghi
            'last_page' => $lastPage,                  // Trang cuối cùng
            'from' => ($page - 1) * $perPage + 1,      // Bản ghi bắt đầu
            'to' => min($page * $perPage, $total),     // Bản ghi kết thúc
            'has_more_pages' => $page < $lastPage,     // Còn trang tiếp không
            'prev_page' => $page > 1 ? $page - 1 : null,      // Trang trước
            'next_page' => $page < $lastPage ? $page + 1 : null, // Trang sau
        ];
    }

    /**
     * Xây dựng câu truy vấn SELECT hoàn chỉnh
     * @return string Câu SQL SELECT
     */
    protected function buildSelectQuery()
    {
        $columns = implode(', ', $this->selectColumns);
        $sql = "SELECT {$columns} FROM {$this->getTable()}";

        $sql .= $this->buildWhereClause();
        $sql .= $this->buildOrderClause();
        $sql .= $this->buildLimitClause();

        return $sql;
    }

    /**
     * Xây dựng mệnh đề WHERE từ các điều kiện đã thêm
     * @return string Mệnh đề WHERE hoặc chuỗi rỗng
     */
    protected function buildWhereClause()
    {
        if (empty($this->wheres)) {
            return '';
        }

        $clauses = [];
        foreach ($this->wheres as $index => $where) {
            // Điều kiện đầu tiên không cần AND/OR
            $prefix = $index === 0 ? '' : " {$where['boolean']} ";

            if (isset($where['type'])) {
                // Xử lý các loại điều kiện đặc biệt
                switch ($where['type']) {
                    case 'In':
                        $placeholders = implode(',', array_fill(0, count($where['values']), '?'));
                        $clauses[] = "{$prefix}{$where['column']} IN ({$placeholders})";
                        break;
                    case 'NotIn':
                        $placeholders = implode(',', array_fill(0, count($where['values']), '?'));
                        $clauses[] = "{$prefix}{$where['column']} NOT IN ({$placeholders})";
                        break;
                    case 'Null':
                        $clauses[] = "{$prefix}{$where['column']} IS NULL";
                        break;
                    case 'NotNull':
                        $clauses[] = "{$prefix}{$where['column']} IS NOT NULL";
                        break;
                    case 'Between':
                        $clauses[] = "{$prefix}{$where['column']} BETWEEN ? AND ?";
                        break;
                }
            } else {
                // Điều kiện WHERE thông thường
                $clauses[] = "{$prefix}{$where['column']} {$where['operator']} ?";
            }
        }

        return ' WHERE ' . implode('', $clauses);
    }

    /**
     * Xây dựng mệnh đề ORDER BY
     * @return string Mệnh đề ORDER BY hoặc chuỗi rỗng
     */
    protected function buildOrderClause()
    {
        if (empty($this->orders)) {
            return '';
        }

        $clauses = [];
        foreach ($this->orders as $order) {
            $clauses[] = "{$order['column']} {$order['direction']}";
        }

        return ' ORDER BY ' . implode(', ', $clauses);
    }

    /**
     * Xây dựng mệnh đề LIMIT và OFFSET
     * @return string Mệnh đề LIMIT OFFSET hoặc chuỗi rỗng
     */
    protected function buildLimitClause()
    {
        $sql = '';

        if ($this->limitValue !== null) {
            $sql .= " LIMIT {$this->limitValue}";
        }

        if ($this->offsetValue !== null) {
            $sql .= " OFFSET {$this->offsetValue}";
        }

        return $sql;
    }

    // ==================== THÊM / SỬA / XÓA (CREATE / UPDATE / DELETE) ====================

    /**
     * Lưu model vào database
     * Tự động phân biệt INSERT (mới) hoặc UPDATE (đã tồn tại)
     * @return bool Thành công hay không
     * 
     * Ví dụ:
     * // Thêm mới
     * $customer = new Customer();
     * $customer->ho_ten = 'Nguyễn Văn A';
     * $customer->save(); // INSERT
     * 
     * // Cập nhật
     * $customer = Customer::find(1);
     * $customer->ho_ten = 'Tên mới';
     * $customer->save(); // UPDATE
     */
    public function save()
    {
        if ($this->exists) {
            return $this->performUpdate();
        }

        return $this->performInsert();
    }

    /**
     * Thực hiện INSERT bản ghi mới
     * Tự động thêm timestamps nếu được bật
     * @return bool
     */
    protected function performInsert()
    {
        $attributes = $this->getAttributesForInsert();

        // Tự động thêm created_at và updated_at nếu timestamps = true
        if ($this->timestamps) {
            $now = date('Y-m-d H:i:s');
            $attributes['created_at'] = $now;
            $attributes['updated_at'] = $now;
        }

        // Xây dựng câu SQL INSERT
        $columns = implode(', ', array_keys($attributes));
        $placeholders = implode(', ', array_fill(0, count($attributes), '?'));

        $sql = "INSERT INTO {$this->getTable()} ({$columns}) VALUES ({$placeholders})";

        $stmt = static::$connection->prepare($sql);
        $stmt->execute(array_values($attributes));

        // Lấy ID vừa được tạo và gán vào model
        $this->setAttribute($this->primaryKey, static::$connection->lastInsertId());
        $this->exists = true;

        // Cập nhật timestamps vào model
        if ($this->timestamps) {
            $this->setAttribute('created_at', $attributes['created_at']);
            $this->setAttribute('updated_at', $attributes['updated_at']);
        }

        $this->syncOriginal();

        return true;
    }

    /**
     * Thực hiện UPDATE bản ghi
     * Chỉ cập nhật những trường đã thay đổi (dirty)
     * @return bool
     */
    protected function performUpdate()
    {
        // Lấy các trường đã thay đổi
        $dirty = $this->getDirty();

        // Nếu không có gì thay đổi, không cần update
        if (empty($dirty)) {
            return true;
        }

        // Tự động cập nhật updated_at nếu timestamps = true
        if ($this->timestamps) {
            $dirty['updated_at'] = date('Y-m-d H:i:s');
        }

        // Xây dựng phần SET của câu SQL
        $sets = [];
        foreach (array_keys($dirty) as $column) {
            $sets[] = "{$column} = ?";
        }

        $sql = "UPDATE {$this->getTable()} SET " . implode(', ', $sets);
        $sql .= " WHERE {$this->primaryKey} = ?";

        // Giá trị binding: các giá trị mới + ID
        $values = array_values($dirty);
        $values[] = $this->getKey();

        $stmt = static::$connection->prepare($sql);
        $stmt->execute($values);

        // Cập nhật attributes với giá trị mới
        foreach ($dirty as $key => $value) {
            $this->setAttribute($key, $value);
        }

        $this->syncOriginal();

        return true;
    }

    /**
     * Cập nhật một hoặc nhiều bản ghi
     * Có thể dùng trên instance hoặc qua query builder
     * @param array $attributes Mảng các trường cần cập nhật
     * @return bool|int Thành công (instance) hoặc số bản ghi đã update (mass update)
     * 
     * Ví dụ:
     * // Cập nhật instance
     * $customer = Customer::find(1);
     * $customer->update(['ho_ten' => 'Tên mới']);
     * 
     * // Mass update qua query builder
     * Customer::where('status', 0)->update(['status' => 1]);
     */
    public function update(array $attributes)
    {
        // Nếu đây là query builder (chưa load model cụ thể), thực hiện mass update
        if (!$this->exists && !empty($this->wheres)) {
            return $this->performMassUpdate($attributes);
        }

        // Nếu là instance đã load, fill attributes rồi save
        $this->fill($attributes);
        return $this->save();
    }

    /**
     * Thực hiện cập nhật hàng loạt qua query builder
     * @param array $attributes Mảng các trường cần cập nhật
     * @return int Số bản ghi đã được cập nhật
     */
    protected function performMassUpdate(array $attributes)
    {
        // Tự động cập nhật updated_at
        if ($this->timestamps) {
            $attributes['updated_at'] = date('Y-m-d H:i:s');
        }

        // Xây dựng phần SET
        $sets = [];
        $values = [];
        foreach ($attributes as $column => $value) {
            $sets[] = "{$column} = ?";
            $values[] = $value;
        }

        $sql = "UPDATE {$this->getTable()} SET " . implode(', ', $sets);
        $sql .= $this->buildWhereClause();

        // Kết hợp giá trị SET và giá trị WHERE
        $allBindings = array_merge($values, $this->bindings);

        $stmt = static::$connection->prepare($sql);
        $stmt->execute($allBindings);

        return $stmt->rowCount();
    }

    /**
     * Xóa bản ghi
     * Có thể dùng trên instance hoặc qua query builder
     * @return bool|int Thành công (instance) hoặc số bản ghi đã xóa (mass delete)
     * 
     * Ví dụ:
     * // Xóa instance
     * $customer = Customer::find(1);
     * $customer->delete();
     * 
     * // Mass delete qua query builder
     * Customer::where('status', 'deleted')->delete();
     */
    public function delete()
    {
        // Nếu đây là query builder, thực hiện mass delete
        if (!$this->exists && !empty($this->wheres)) {
            return $this->performMassDelete();
        }

        // Không thể xóa bản ghi chưa tồn tại
        if (!$this->exists) {
            return false;
        }

        $sql = "DELETE FROM {$this->getTable()} WHERE {$this->primaryKey} = ?";

        $stmt = static::$connection->prepare($sql);
        $stmt->execute([$this->getKey()]);

        $this->exists = false;

        return $stmt->rowCount() > 0;
    }

    /**
     * Thực hiện xóa hàng loạt qua query builder
     * @return int Số bản ghi đã xóa
     */
    protected function performMassDelete()
    {
        $sql = "DELETE FROM {$this->getTable()}";
        $sql .= $this->buildWhereClause();

        $stmt = static::$connection->prepare($sql);
        $stmt->execute($this->bindings);

        return $stmt->rowCount();
    }

    // ==================== XỬ LÝ THUỘC TÍNH (ATTRIBUTE HANDLING) ====================

    /**
     * Gán hàng loạt các thuộc tính cho model
     * Chỉ gán những trường được phép (fillable) và không bị chặn (guarded)
     * @param array $attributes Mảng các thuộc tính
     * @return Model
     * 
     * Ví dụ:
     * $customer = new Customer();
     * $customer->fill(['ho_ten' => 'Tên', 'email' => 'email@mail.com']);
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * Kiểm tra một thuộc tính có được phép gán không
     * @param string $key Tên thuộc tính
     * @return bool
     */
    protected function isFillable($key)
    {
        // Nếu $fillable rỗng, cho phép tất cả trừ những cái trong $guarded
        if (empty($this->fillable)) {
            return !in_array($key, $this->guarded);
        }

        // Nếu $fillable có giá trị, chỉ cho phép những cái trong đó
        return in_array($key, $this->fillable);
    }

    /**
     * Lấy các thuộc tính có thể INSERT (đã lọc theo fillable/guarded)
     * @return array
     */
    protected function getAttributesForInsert()
    {
        $attributes = [];
        foreach ($this->attributes as $key => $value) {
            if ($this->isFillable($key) || $key === $this->primaryKey) {
                $attributes[$key] = $value;
            }
        }
        return $attributes;
    }

    /**
     * Đặt giá trị cho một thuộc tính
     * @param string $key Tên thuộc tính
     * @param mixed $value Giá trị
     * @return Model
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Lấy giá trị của một thuộc tính
     * @param string $key Tên thuộc tính
     * @return mixed|null Giá trị hoặc null nếu không tồn tại
     */
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Lấy tất cả thuộc tính của model
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Đồng bộ thuộc tính hiện tại thành giá trị gốc
     * Dùng sau khi lưu để reset trạng thái "dirty"
     * @return Model
     */
    protected function syncOriginal()
    {
        $this->original = $this->attributes;
        return $this;
    }

    /**
     * Lấy các thuộc tính đã thay đổi so với giá trị gốc
     * @return array Mảng các thuộc tính đã thay đổi
     */
    public function getDirty()
    {
        $dirty = [];
        foreach ($this->attributes as $key => $value) {
            // Nếu key không có trong original hoặc giá trị khác
            if (!array_key_exists($key, $this->original) || $this->original[$key] !== $value) {
                // Không bao gồm primary key
                if ($key !== $this->primaryKey) {
                    $dirty[$key] = $value;
                }
            }
        }
        return $dirty;
    }

    /**
     * Kiểm tra model có thay đổi không
     * @param string|null $attribute Tên thuộc tính cụ thể (tùy chọn)
     * @return bool
     * 
     * Ví dụ:
     * $customer->isDirty();         // Có thay đổi gì không?
     * $customer->isDirty('email');  // Email có thay đổi không?
     */
    public function isDirty($attribute = null)
    {
        $dirty = $this->getDirty();

        if ($attribute === null) {
            return !empty($dirty);
        }

        return array_key_exists($attribute, $dirty);
    }

    /**
     * Chuyển model thành mảng
     * @return array
     * 
     * Ví dụ:
     * $customer = Customer::find(1);
     * $array = $customer->toArray();
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Chuyển model thành chuỗi JSON
     * @param int $options Tùy chọn json_encode (VD: JSON_PRETTY_PRINT)
     * @return string
     * 
     * Ví dụ:
     * $customer = Customer::find(1);
     * echo $customer->toJson();
     * echo $customer->toJson(JSON_PRETTY_PRINT);
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    // ==================== MAGIC METHODS - PHƯƠNG THỨC MA THUẬT ====================

    /**
     * Magic getter - Cho phép truy cập thuộc tính như property
     * @param string $key Tên thuộc tính
     * @return mixed
     * 
     * Ví dụ:
     * echo $customer->ho_ten;  // Tương đương $customer->getAttribute('ho_ten')
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Magic setter - Cho phép gán giá trị như property
     * @param string $key Tên thuộc tính
     * @param mixed $value Giá trị
     * 
     * Ví dụ:
     * $customer->ho_ten = 'Tên mới';  // Tương đương $customer->setAttribute('ho_ten', 'Tên mới')
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Magic isset - Kiểm tra thuộc tính có tồn tại không
     * @param string $key Tên thuộc tính
     * @return bool
     * 
     * Ví dụ:
     * isset($customer->ho_ten);
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Magic unset - Xóa một thuộc tính
     * @param string $key Tên thuộc tính
     * 
     * Ví dụ:
     * unset($customer->temp_data);
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Xử lý gọi phương thức tĩnh không tồn tại
     * 
     * Cho phép gọi các Query Builder method như static method:
     * Customer::orderByDesc('id')->get();
     * Customer::whereIn('id', [1, 2, 3])->get();
     * Customer::select('id', 'name')->get();
     * Customer::limit(10)->get();
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static();

        // Kiểm tra nếu có method nội bộ _method
        $internalMethod = '_' . $method;
        if (method_exists($instance, $internalMethod)) {
            return $instance->$internalMethod(...$parameters);
        }

        return $instance->$method(...$parameters);
    }

    /**
     * Xử lý gọi phương thức không tồn tại trên instance
     * 
     * Hỗ trợ:
     * 1. Query Builder: orderBy, limit, offset, whereIn, select...
     * 2. Dynamic where: whereStatus(), whereEmail(), whereHoTen()...
     * 
     * Ví dụ:
     * Customer::where('status', 1)->orderByDesc('id')->limit(10)->get();
     * Customer::whereIn('id', [1, 2, 3])->get();
     */
    public function __call($method, $parameters)
    {
        // Kiểm tra nếu có method nội bộ _method (Query Builder)
        $internalMethod = '_' . $method;
        if (method_exists($this, $internalMethod)) {
            return $this->$internalMethod(...$parameters);
        }

        // Hỗ trợ dynamic where methods (whereStatus, whereEmail, whereHoTen...)
        if (strpos($method, 'where') === 0 && strlen($method) > 5) {
            $column = substr($method, 5);
            // Chuyển CamelCase thành snake_case (VD: HoTen -> ho_ten)
            $column = strtolower(preg_replace('/([A-Z])/', '_$1', $column));
            $column = ltrim($column, '_');
            return $this->addWhere($column, '=', $parameters[0] ?? null, 'AND');
        }

        throw new \BadMethodCallException("Phương thức {$method} không tồn tại.");
    }

    /**
     * Chuyển model thành chuỗi khi echo
     * @return string JSON của model
     * 
     * Ví dụ:
     * echo $customer;  // In ra JSON
     */
    public function __toString()
    {
        return $this->toJson();
    }
}

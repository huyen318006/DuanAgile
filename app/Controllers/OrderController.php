<?php
namespace App\Controllers;
use App\Controller;
use App\Models\Food;
use App\Models\FoodSize;
use App\Models\FoodTopping;
use App\Models\Order;
use App\Models\Size;
use App\Models\Topping;
use App\Models\OrderItem;

class  OrderController extends Controller {

public function order($id)
{
    //dựa vào id của food
   $food=Food::find($id);


   //lấy các size  dựa vào id của food
   $sizel=FoodSize::where('food_id',$id)->get();
   $size=[];
   foreach($sizel as $sizename)
    {
        $size[]=Size::find($sizename->size_id);

    }
    $food->size=$size;


    //lấy topping
    //dựa vào id của food để lấy id của topping đi kèm nó
    $toppingid=FoodTopping::where('food_id',$id)->get();
     //lúc này nó đã lấy ra 1 mảng  id  topping dựa theo sản phẩm, vì là 1 mảng ta cần phải duyệt để  lấy giá trị tương ứng theo tưng id topping
     $topping=[];
     foreach($toppingid as $toppings){
        $topping[]=Topping::find($toppings->topping_id);
     }
     $food->topping=$topping;
   

     return view('order.orders',compact('food'));
   
}

    //order add
    public function orderadd()
    {
       try {
            if (!isset($_SESSION['user']['id'])) {
                throw new \Exception("Vui lòng đăng nhập để thực hiện đặt hàng.");
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception('Yêu cầu không hợp lệ.');
            }

            $totalPrice = $_POST['totalPrice'] ?? 0;
            $foodId = $_POST['food_id'] ?? null;
            $sizeId = $_POST['size'] ?? null;
            $toppingId = $_POST['topping'] ?? null;
            $pay = $_POST['payment_method'] ?? 'Cash';
            $userId = $_SESSION['user']['id'];

            $receiver = !empty($_POST['receiver']) ? $_POST['receiver'] : ($_SESSION['user']['name'] ?? 'Guest');
            $phone = !empty($_POST['phone']) ? $_POST['phone'] : ($_SESSION['user']['phone'] ?? null);
            $note = $_POST['note'] ?? '';

            // Lấy số lượng
            $quantity = $_POST['quantity'] ?? 1;

            $address = $_SESSION['user']['address'] ?? null;

            if (!$address) {
                throw new \Exception('Không có địa chỉ giao hàng trong hồ sơ của bạn.');
            }

            $data = [
                'user_id' => $userId,
                'food_id' => $foodId,
                'size_id' => $sizeId,
                'payment_method' => $pay,
                'total_price' => $totalPrice,
                'address' => $address,
                'status' => 'processing',
                'receiver' => $receiver,
                'phone' => (is_numeric($phone) ? $phone : null),
                'note' => $note,
            ];

        $orderneww=Order::create($data);
        //lấy id mới tạo
        $order_id=$orderneww->id;
        // Xử lý Topping an toàn (không bắt buộc chọn)
        $tIds = (array)($toppingId ?? []);
        if (!empty($tIds)) {
            foreach ($tIds as $tid) {
                OrderItem::create([
                    'order_id' => $order_id,
                    'food_id' => $foodId,
                    'topping_id' => $tid,
                    'quantity' => $quantity,
                    'size_id' => $sizeId
                ]);
            }
        } else {
            // Trường hợp không chọn topping, vẫn tạo 1 dòng item với topping_id = null
            OrderItem::create([
                'order_id' => $order_id,
                'food_id' => $foodId,
                'topping_id' => null,
                'quantity' => $quantity,
                'size_id' => $sizeId
            ]);
        }

        
        echo "<script>
        alert('🎉 Đặt hàng thành công! Cảm ơn bạn đã tin tưởng.');
        window.location.href = '" . APP_URL . "foods';
    </script>";
        exit();  // Dừng để script chạy
       }catch (\Exception $e) {
        echo "<script>
            alert('❌ Đặt hàng thất bại: " . addslashes($e->getMessage()) . "');
            window.location.href = '" . APP_URL . "foods';
        </script>";
    }

    }


    //order history 
    public function orderHistory()
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            die('Không có user_id trong session');
        }

        $orders = Order::where('user_id', $userId)->get();

        foreach ($orders as $order) {
            // Lấy tất cả order_items
            $orderItems = OrderItem::where('order_id', $order->id)->get();

            $sizes = [];
            $toppings = [];
            $foodIds = [];

            foreach ($orderItems as $item) {
                // Lấy size
                if ($item->size_id) {
                    $sizes[] = Size::find($item->size_id);
                }

                // Lấy topping
                if ($item->topping_id) {
                    $toppings[] = Topping::find($item->topping_id);
                }
                // Lấy food_id để sau này có thể hiển thị tên món ăn
                if ($item->food_id) {
                    $foodIds[] = Food::find($item->food_id);
                }
            }

            // Gán mảng vào order
            $order->sizes = $sizes;
            $order->toppings = $toppings;
            $order->foodIds = $foodIds;
        }

        return view('order.listorder', compact('orders'));
    }
} 
?>
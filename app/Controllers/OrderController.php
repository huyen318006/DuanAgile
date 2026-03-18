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
        $totalPrice = $_POST['totalPrice'] ?? 0;
        $foodId = $_POST['food_id'] ?? null;
        $sizeId = $_POST['size'] ?? null;
        $toppingId = $_POST['topping'] ?? null;
        $pay = $_POST['payment_method'] ?? 'Cash';
        $userId = $_SESSION['user']['id'] ?? 1;

        //lấy số lượng
        $quantity = $_POST['quantity'] ?? 1;
      

        $address = $_SESSION['user']['address'] ?? null;

        if (!$address) {
            die('Không có address trong session');
        }
        $data = [
            'user_id' => $userId,
            'food_id' => $foodId,
            'size_id' => $sizeId,
            'payment_method' => $pay,
            'total_price' => $totalPrice,
            'address' => $address,
            'status' => 'processing'
        ];

        $orderneww=Order::create($data);
        //lấy id mới tạo
        $order_id=$orderneww->id;
        //lưu topping vào bảng trung gian
        foreach ($toppingId as $toppingid) {
            OrderItem::create([
                'order_id' => $order_id,
                'food_id' => $foodId,
                'topping_id' => $toppingid, // từng cái 1
                'quantity' => $quantity,
                'size_id' => $sizeId
            ]);
        }

        
        echo "<script>
        alert('🎉 Đặt hàng thành công! Cảm ơn bạn đã tin tưởng.');
        window.location.href = '" . APP_URL . "foods';
    </script>";
        exit();  // Dừng để script chạy

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
<?php
namespace App\Controllers;
use App\Controller;
use App\Models\Food;
use App\Models\FoodSize;
use App\Models\FoodTopping;
use App\Models\Order;
use App\Models\Size;
use App\Models\Topping;

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
        $toppingIds = $_POST['topping'] ?? [];
        $pay = $_POST['payment_method'] ?? 'Cash';
        $userId = $_SESSION['user']['id'] ?? 1;
      

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

        Order::create($data);
        echo "<script>
        alert('🎉 Đặt hàng thành công! Cảm ơn bạn đã tin tưởng.');
        window.location.href = '" . APP_URL . "foods';
    </script>";
        exit();  // Dừng để script chạy

    }
} 
?>
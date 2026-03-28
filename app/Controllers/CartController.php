<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Users;
use App\Models\Size;
use App\Models\Topping;

/**
 * CartController - Quản lý giỏ hàng của người dùng
 *
 * Các chức năng:
 * - index()       : Hiển thị trang giỏ hàng
 * - add()         : Thêm món ăn vào giỏ (hỗ trợ cả form submit và AJAX)
 * - update($id)   : Cập nhật số lượng món trong giỏ (hỗ trợ AJAX)
 * - delete($id)   : Xóa món khỏi giỏ hàng
 */
class CartController extends Controller
{

    /**
     * Hiển thị trang giỏ hàng của user đang đăng nhập
     *
     * Lấy tất cả cart items của user, kèm thông tin món ăn và tổng tiền,
     * sau đó truyền sang view carts.list để render
     */
    public function index()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            header('location:' . APP_URL . 'login');
            exit();
        }

        $title = 'Giỏ hàng';
        $carts = Cart::where('user_id', $userId)->get();

        $foods = [];
        foreach (Food::all() as $f) {
            $foods[$f->id] = $f;
        }

        $sizes = [];
        foreach (Size::all() as $s) {
            $sizes[$s->id] = $s;
        }

        $toppingsMap = [];
        foreach (Topping::all() as $t) {
            $toppingsMap[$t->id] = $t;
        }

        $total = 0;
        foreach ($carts as $cart) {
            $food = $foods[$cart->food_id] ?? null;
            if (!$food) continue;
            $unitPrice = $food->price;
            if ($cart->size_id && isset($sizes[$cart->size_id])) {
                $unitPrice += $sizes[$cart->size_id]->price;
            }
            if ($cart->topping_ids) {
                $ids = json_decode($cart->topping_ids, true);
                if (is_array($ids)) {
                    foreach ($ids as $tid) {
                        if (isset($toppingsMap[$tid])) {
                            $unitPrice += $toppingsMap[$tid]->price;
                        }
                    }
                }
            }
            $total += $unitPrice * $cart->quantity;
        }

        $user = Users::find($userId);

        return view('carts.list', compact('carts', 'title', 'foods', 'total', 'user', 'sizes', 'toppingsMap'));
    }

    /**
     * Thêm món ăn vào giỏ hàng
     *
     * Nếu món đã tồn tại trong giỏ → cộng dồn số lượng
     * Nếu chưa có → tạo bản ghi mới
     *
     * Hỗ trợ 2 kiểu response:
     * - AJAX (XMLHttpRequest): trả JSON { success, message, cart_count }
     * - Form submit thường: redirect về trang giỏ hàng
     */
    public function add()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('login');
        }

        $foodId = $_POST['food_id'];
        $food = Food::find($foodId);
        if (!$food) {
            return redirect('foods');
        }

        // Kiểm tra nếu món có size thì bắt buộc phải chọn
        $hasSizes = \App\Models\FoodSize::where('food_id', $foodId)->exists();
        $sizeId = !empty($_POST['size_id']) ? $_POST['size_id'] : null;

        if ($hasSizes && empty($sizeId)) {
            echo "<script>alert('Vui lòng chọn kích cỡ (Size) cho món ăn này.'); window.history.back();</script>";
            exit;
        }

        $toppingIds = $_POST['topping_ids'] ?? [];
        $toppingJson = !empty($toppingIds) ? json_encode($toppingIds) : null;

        $data = [
            'user_id'     => $userId,
            'food_id'     => $foodId,
            'quantity'    => $_POST['quantity'] ?? 1,
            'size_id'     => $sizeId,
            'topping_ids' => $toppingJson,
        ];

        $existing = Cart::where('user_id', $userId)->where('food_id', $data['food_id'])->first();

        // Kiểm tra xem item đã tồn tại với cùng tùy chọn chưa
        $isSameOptions = $existing
            && (string)($existing->size_id ?? '') === (string)($sizeId ?? '')
            && (string)($existing->topping_ids ?? '') === (string)($toppingJson ?? '');

        if ($isSameOptions) {
            $existing->update(['quantity' => $existing->quantity + $data['quantity']]);
        } else {
            Cart::create($data);
        }

        // Nếu là AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            $cartCount = count(Cart::where('user_id', $userId)->get());
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng!', 'cart_count' => $cartCount]);
            exit();
        }

        return redirect('cart');
    }

    /**
     * Cập nhật số lượng của một món trong giỏ hàng
     */
    public function update($id)
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('login');
        }

        $cart = Cart::find($id);

        if ($cart && $cart->user_id == $userId) {
            $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
            $sizeId = !empty($_POST['size_id']) ? $_POST['size_id'] : null;

            // Kiểm tra size khi cập nhật
            $hasSizes = \App\Models\FoodSize::where('food_id', $cart->food_id)->exists();
            if ($hasSizes && empty($sizeId)) {
                echo "<script>alert('Vui lòng chọn Size cho món ăn.'); window.history.back();</script>";
                exit;
            }

            $toppingIds = $_POST['topping_ids'] ?? [];
            $toppingJson = !empty($toppingIds) ? json_encode($toppingIds) : null;

            $cart->update([
                'quantity'    => $quantity,
                'size_id'     => $sizeId,
                'topping_ids' => $toppingJson,
            ]);
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Cập nhật giỏ hàng thành công!']);
            exit();
        }

        return redirect('cart');
    }

    /**
     * Xóa một món khỏi giỏ hàng
     */
    public function delete($id)
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            header('location:' . APP_URL . 'login');
            exit();
        }

        $cart = Cart::find($id);

        if ($cart && $cart->user_id == $userId) {
            $cart->delete();
        }

        return redirect('cart');
    }

    /**
     * Lưu đơn hàng từ giỏ hàng
     */
    public function store()
    {
        try {
            if (!isset($_SESSION['user']['id'])) {
                die("Lỗi: Bạn cần phải đăng nhập để thực hiện đặt hàng.");
            }

            $userId = $_SESSION['user']['id'];
            $carts = Cart::where('user_id', $userId)->get();

            if (empty($carts)) {
                die("Lỗi: Giỏ hàng trống.");
            }

            // 1. Validate: Kiểm tra tất cả các món trong giỏ đã có size chưa (nếu món đó có size)
            foreach ($carts as $item) {
                $hasSizes = \App\Models\FoodSize::where('food_id', $item->food_id)->exists();
                if ($hasSizes && empty($item->size_id)) {
                    $food = Food::find($item->food_id);
                    $foodName = $food->name ?? "Sản phẩm";
                    echo "<script>alert('Món \"{$foodName}\" chưa được chọn Size. Vui lòng cập nhật lại giỏ hàng.'); window.location.href='/cart';</script>";
                    exit;
                }
            }

            $receiver = $_POST['checkout_name'] ?? 'Guest';
            $phone = $_POST['checkout_phone'] ?? '';
            $address = $_POST['checkout_address'] ?? '';
            $note = $_POST['checkout_notes'] ?? '';
            $totalPrice = (float)($_POST['price'] ?? 0);
            $paymentMethod = $_POST['checkout_payment'] ?? 'Cash';

            // 2. Tạo Order
            $order = Order::create([
                'user_id' => $userId,
                'receiver' => $receiver,
                'phone' => $phone,
                'address' => $address,
                'note' => $note,
                'total_price' => $totalPrice,
                'payment_method' => $paymentMethod,
                'status' => 'processing'
            ]);

            // Maps để tính toán giá chính xác cho từng dòng OrderItem
            $foodsMap = [];
            foreach (Food::all() as $f) $foodsMap[$f->id] = $f;
            $sizesMap = [];
            foreach (Size::all() as $s) $sizesMap[$s->id] = $s;
            $toppingsMap = [];
            foreach (Topping::all() as $t) $toppingsMap[$t->id] = $t;

            // 3. Chuyển cart sang OrderItem
            foreach ($carts as $cart) {
                $food = $foodsMap[$cart->food_id] ?? null;
                if (!$food) continue;

                // Tính toán giá đơn vị (bao gồm size và toppings)
                $unitPrice = (float)$food->price;
                if ($cart->size_id && isset($sizesMap[$cart->size_id])) {
                    $unitPrice += (float)$sizesMap[$cart->size_id]->price;
                }

                $tIds = [];
                if ($cart->topping_ids) {
                    $tIds = json_decode($cart->topping_ids, true) ?: [];
                }

                foreach ($tIds as $tid) {
                    if (isset($toppingsMap[$tid])) {
                        $unitPrice += (float)$toppingsMap[$tid]->price;
                    }
                }

                // Lưu từng topping thành 1 dòng (theo style của dự án)
                if (!empty($tIds)) {
                    foreach ($tIds as $tid) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'food_id' => $cart->food_id,
                            'quantity' => $cart->quantity,
                            'size_id' => $cart->size_id,
                            'topping_id' => $tid,
                        ]);
                    }
                } else {
                    // Không có topping -> lưu 1 dòng topping_id = null
                    OrderItem::create([
                        'order_id' => $order->id,
                        'food_id' => $cart->food_id,
                        'quantity' => $cart->quantity,
                        'size_id' => $cart->size_id,
                        'topping_id' => null,
                    ]);
                }
                
                // Xóa cart sau khi đã tạo OrderItem thành công cho món đó
                $cart->delete();
            }

            $historyUrl = APP_URL . "order/history";
            echo "<script>
                alert('🎉 Đặt món từ giỏ hàng thành công! Cảm ơn bạn.');
                window.location.href = '{$historyUrl}';
            </script>";
            exit();

        } catch (\Exception $e) {
            die("Lỗi Hệ Thống: " . $e->getMessage());
        }
    }
}

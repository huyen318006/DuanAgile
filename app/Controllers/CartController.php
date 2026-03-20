<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Cart;
use App\Models\Food;
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

        $sizeId = !empty($_POST['size_id']) ? $_POST['size_id'] : null;
        $toppingIds = $_POST['topping_ids'] ?? [];
        $toppingJson = !empty($toppingIds) ? json_encode($toppingIds) : null;

        $data = [
            'user_id'     => $userId,
            'food_id'     => $_POST['food_id'],
            'quantity'    => $_POST['quantity'] ?? 1,
            'size_id'     => $sizeId,
            'topping_ids' => $toppingJson,
        ];

        $existing = Cart::where('user_id', $userId)->where('food_id', $data['food_id'])->first();

        $isSameOptions = $existing
            && (string)($existing->size_id ?? '') === (string)($sizeId ?? '')
            && (string)($existing->topping_ids ?? '') === (string)($toppingJson ?? '');

        if ($isSameOptions) {
            $existing->update(['quantity' => $existing->quantity + $data['quantity']]);
        } else {
            Cart::create($data);
        }

        // Nếu là AJAX request → trả JSON để frontend hiển thị toast, không redirect
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
     *
     * Chỉ cho phép cập nhật nếu cart item thuộc về user đang đăng nhập
     * Số lượng tối thiểu là 1
     *
     * Hỗ trợ 2 kiểu response:
     * - AJAX: trả JSON { success, quantity } để frontend cập nhật UI không cần reload
     * - Form submit: redirect về trang giỏ hàng
     *
     * @param int $id ID của bản ghi cart cần cập nhật
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
     *
     * Chỉ cho phép xóa nếu cart item thuộc về user đang đăng nhập
     *
     * @param int $id ID của bản ghi cart cần xóa
     */
    public function delete($id)
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            header('location:' . APP_URL . 'login');
            exit();
        }

        $cart = Cart::find($id);

        // Chỉ cho phép xóa cart của chính user đó
        if ($cart && $cart->user_id == $userId) {
            $cart->delete();
        }

        return redirect('cart');
    }
}

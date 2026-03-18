<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Cart;
use App\Models\Food;
use App\Models\Users;
class CartController extends Controller
{

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

        $total = 0;
        foreach ($carts as $cart) {
            $food = $foods[$cart->food_id] ?? null;
            if ($food) {
                $total += $food->price * $cart->quantity;
            }
        }

        $user = Users::find($userId);

        return view('carts.list', compact('carts', 'title', 'foods', 'total', 'user'));
    }

    public function add()
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('login');
        }

        $data = [
            'user_id'  => $userId,
            'food_id'  => $_POST['food_id'],
            'quantity' => $_POST['quantity'] ?? 1,
        ];

        $existing = Cart::where('user_id', $userId)->where('food_id', $data['food_id'])->first();

        if ($existing) {
            $existing->update(['quantity' => $existing->quantity + $data['quantity']]);
        } else {
            Cart::create($data);
        }

        return redirect('cart');
    }

    public function update($id)
    {
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('login');
        }

        $cart = Cart::find($id);

        if ($cart && $cart->user_id == $userId) {
            $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
            $cart->update(['quantity' => $quantity]);
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'quantity' => $quantity]);
            exit();
        }

        return redirect('cart');
    }

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
}

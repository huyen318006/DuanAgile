<?php
namespace App\Controllers;

use App\Controller;
use App\Models\Food;
use App\Models\Restaurant;
use App\Models\Post;
use App\Models\Category;


class FoodController extends Controller
{

 public function index()
 {
    $title='Food List';
    // GỢI Ý THEO USER
    $userId = $_SESSION['user']['id'] ?? null;
    if ($userId) {
        $conn = Food::getConnection();
        $sql = "
              SELECT f.*, COUNT(oi.food_id) AS total_order
              FROM orders o
              JOIN order_items oi ON o.id = oi.order_id
              JOIN foods f ON f.id = oi.food_id
              WHERE o.user_id = $userId
              GROUP BY f.id
              ORDER BY total_order DESC
              LIMIT 12
          ";
          $stmt = $conn->query($sql);
            $recommendedFoods = $stmt->fetchAll(\PDO::FETCH_OBJ);
        } else {
            // chưa login → random
            $recommendedFoods = Food::orderBy('RAND()')->limit(12)->get();
        }
       // ==============================
        //2. MÓN PHỔ BIẾN (TOÀN HỆ THỐNG)
        // ==============================
        $conn = Food::getConnection();
        $sqlPopular = "
            SELECT f.*, COUNT(oi.food_id) AS total_order
            FROM foods f
            JOIN order_items oi ON f.id = oi.food_id
            GROUP BY f.id
            HAVING total_order > 0
            ORDER BY total_order DESC
            LIMIT 12
        ";
        $stmtPopular = $conn->query($sqlPopular);
        $popularFoods = $stmtPopular->fetchAll(\PDO::FETCH_OBJ);
    $restaurants=Restaurant::all();
      $posts = Post::orderBy('RAND()')->limit(3)->get();
    $categories = Category::all();
    return view('foods.list',compact('recommendedFoods','title','restaurants','posts','categories','popularFoods'));
 }
}
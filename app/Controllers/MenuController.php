<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Food;
use App\Models\Category;
use App\Models\FoodSize;
use App\Models\FoodTopping;
use App\Models\Size;
use App\Models\Topping;
use App\Models\Restaurant;

class MenuController extends Controller
{

    public function index()
    {
        $title = 'Food List';
        $foods = Food::all();
        $categories = Category::all();

        // Load restaurants map for food detail popup
        $restaurantsMap = [];
        foreach (Restaurant::all() as $r) {
            $restaurantsMap[$r->id] = $r;
        }

        return view('menus.list', compact('foods', 'title', 'categories', 'restaurantsMap'));
    }

    public function foodOptions($id)
    {
        $food = Food::find($id);
        if (!$food) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Food not found']);
            exit();
        }

        $sizeRows = FoodSize::where('food_id', $id)->get();
        $sizes = [];
        foreach ($sizeRows as $row) {
            if (isset($sizes[$row->size_id])) continue;
            $s = Size::find($row->size_id);
            if ($s) {
                $sizes[$s->id] = ['id' => $s->id, 'name' => $s->name, 'price' => (int) $s->price];
            }
        }
        $sizes = array_values($sizes);

        $toppingRows = FoodTopping::where('food_id', $id)->get();
        $toppings = [];
        foreach ($toppingRows as $row) {
            if (isset($toppings[$row->topping_id])) continue;
            $t = Topping::find($row->topping_id);
            if ($t) {
                $toppings[$t->id] = ['id' => $t->id, 'name' => $t->name, 'price' => (int) $t->price];
            }
        }
        $toppings = array_values($toppings);

        header('Content-Type: application/json');
        echo json_encode([
            'sizes' => $sizes,
            'toppings' => $toppings,
        ]);
        exit();
    }
}

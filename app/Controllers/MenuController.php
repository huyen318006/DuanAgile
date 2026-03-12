<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Food;
use App\Models\Category;

class MenuController extends Controller
{

    public function index()
    {
        $foods = Food::all();
        $categories = Category::all();

        return view('menu', [
            'foods' => $foods,
            'categories' => $categories,
        ]);
    }
}

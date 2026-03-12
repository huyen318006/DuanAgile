<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Food;
use App\Models\Category;

class MenuController extends Controller
{

    public function index()
    {
        $title = 'Food List';
        $foods = Food::all();
        $categories = Category::all();

        return view('menus.list', compact('foods', 'title', 'categories'));
    }
}

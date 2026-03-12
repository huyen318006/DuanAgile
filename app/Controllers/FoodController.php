<?php
namespace App\Controllers;

use App\Controller;
use App\Models\Food;

class FoodController extends Controller
{

    public function index ()
    {
        $title = 'Food List';
        $foods = Food::all();
        return view('foods.list', compact('foods', 'title'));
    }
}
<?php
namespace App\Controllers;

use App\Controller;
use App\Models\Food;
use App\Models\Restaurant;

class FoodController extends Controller
{

    public function index ()
    {
        $title = 'Food List';
        $foods = Food::all();
        $restaurants = Restaurant::all();
        return view('foods.list', compact('foods', 'title', 'restaurants'));
    }

    public function show($id)
    {
        $restaurant = Restaurant::find($id);

        $foods = Food::where('restaurant_id', $id)->get();

        return view('restaurants.show', compact('restaurant','foods'));
    }
}
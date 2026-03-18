<?php

namespace App\Controllers;

use App\Models\Restaurant;
use App\Models\Food;
use App\Models\Size;
use App\Models\Topping;
use App\Models\FoodSize;
use App\Models\FoodTopping;

class RestaurantController
{

public function show($id)
{
    $restaurant = Restaurant::find($id);

    $foods = Food::where('restaurant_id',$id)->get();

    foreach($foods as $food){
        $sizeLinks = FoodSize::where('food_id',$food->id)->get();

        $sizes = [];
        foreach($sizeLinks as $link){
            $sizes[] = Size::find($link->size_id);
        }
        $food->sizes = $sizes;
        $toppingLinks = FoodTopping::where('food_id',$food->id)->get();

        $toppings = [];
        foreach($toppingLinks as $link){
            $toppings[] = Topping::find($link->topping_id);
        }
        $food->toppings = $toppings;
    }

    return view('restaurants.Detail',compact('restaurant','foods'));
}


}
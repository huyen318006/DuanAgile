<?php
namespace App\Controllers;

use App\Controller;
use App\Models\Food;
use App\Models\Restaurant;
use App\Models\Post;


class FoodController extends Controller
{

 public function index()
 {
    $title='Food List';
    $foods = Food::all();
    $restaurants=Restaurant::all();
      $posts = Post::orderBy('RAND()')->limit(3)->get();
    return view('foods.list',compact('foods','title','restaurants','posts'));
 }
}
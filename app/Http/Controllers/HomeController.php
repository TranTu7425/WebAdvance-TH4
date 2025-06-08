<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Category;
use App\Models\Product;
class HomeController extends Controller
{    
    public function index()
    {
        $slides = Slide::where('status', '1')->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $salesProducts = Product::whereNotNull('sale_price')->orderBy('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->get()->take(8);
        return view('index', compact('slides', 'categories', 'salesProducts'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Contact;

class HomeController extends Controller
{    
    public function index()
    {
        $slides = Slide::where('status', '1')->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $salesProducts = Product::whereNotNull('sale_price')->orderBy('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->get()->take(8);
        $featuredProducts = Product::where('featured', '1')->get()->take(8);
        return view('index', compact('slides', 'categories', 'salesProducts', 'featuredProducts'));
    }

    public function contact(Request $request)
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'comment' => 'required',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();

        return redirect()->route('home.contact')->with('success', 'Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ liên hệ lại với bạn sớm nhất có thể.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('short_description', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%")
              ->orWhere('SKU', 'like', "%{$query}%");
        })->get()->take(10);
        return response()->json($results);
    }
}

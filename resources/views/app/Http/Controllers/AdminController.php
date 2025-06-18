<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Slide;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;





class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get()->take(10);
        $dashboardDatas = DB::select("Select sum(total) As TotalAmount,
                                        sum(if(status='ordered',total,0)) As TotalOrderedAmount,
                                        sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
                                        sum(if(status='canceled',total,0)) As TotalCanceledAmount,
                                        Count(*) As Total,
                                        sum(if(status='ordered',1,0)) As TotalOrdered,
                                        sum(if(status='delivered',1,0)) As TotalDelivered,
                                        sum(if(status='canceled',1,0)) As TotalCanceled
                                        From orders
                                        ");
        
        $monthlyDatas = DB::select("SELECT M.id As MonthNo, M.name As MonthName,
                                        IFNULL(D.TotalAmount,0) As TotalAmount,
                                        IFNULL(D.TotalOrderedAmount,0) As TotalOrderedAmount,
                                        IFNULL(D.TotalDeliveredAmount,0) As TotalDeliveredAmount,
                                        IFNULL(D.TotalCanceledAmount,0) As TotalCanceledAmount FROM month_names M
                                        LEFT JOIN (Select DATE_FORMAT(created_at, '%b') As MonthName,
                                        MONTH(created_at) As MonthNo,
                                        sum(total) As TotalAmount,
                                        sum(if(status='ordered',total,0)) As TotalOrderedAmount,
                                        sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
                                        sum(if(status='canceled',total,0)) As TotalCanceledAmount
                                        From orders WHERE YEAR(created_at)=YEAR(NOW()) GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                                        Order By MONTH(created_at)) D On D.MonthNo=M.id");  
                                    
        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $orderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());
        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

    return view('admin.index', compact('orders', 'dashboardDatas', 'AmountM', 'orderedAmountM', 'DeliveredAmountM', 'CanceledAmountM', 'TotalAmount', 'TotalOrderedAmount', 'TotalDeliveredAmount', 'TotalCanceledAmount'));
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.brand-add');
    }

    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:brands,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $filename =  Carbon::now()->timestamp . '.' . $file_extension;
        $this->GernerateBrandThumbnailsImages($image, $filename);
        $brand->image = $filename;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand added successfully!');
    }

    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }

    public function brand_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:brands,slug,'.$request->id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/brands/').'/'.$brand->image))
            {
                File::delete(public_path('uploads/brands/').'/'.$brand->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $filename =  Carbon::now()->timestamp . '.' . $file_extension;
            $this->GernerateBrandThumbnailsImages($image, $filename);
            $brand->image = $filename;
        }
        
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been updated successfully!');
    }

    public function GernerateBrandThumbnailsImages($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands/');
        $img = Image::read($image->path());
        $img->cover(124,124, "top");
        $img->resize(124,124, function ($constraint) {
        $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    public function brand_delete($id)
    {
        $brand = Brand::find($id);
        if(File::exists(public_path('uploads/brands/').'/'.$brand->image))
        {
            File::delete(public_path('uploads/brands/').'/'.$brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'Brand has been deleted successfully!');
    }

    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_category()
    {
        return view('admin.category-add');
    }

    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        
        // Tạo slug từ tên và kiểm tra trùng lặp
        $slug = Str::slug($request->name);
        $count = 1;
        $originalSlug = $slug;
        
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        
        $category->slug = $slug;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $filename = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateCategoryThumbnailsImages($image, $filename);
            $category->image = $filename;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category added successfully!');
    }

    public function GenerateCategoryThumbnailsImages($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories/');
        $img = Image::read($image->path());
        $img->cover(124,124, "top");
        $img->resize(124,124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:categories,slug,'.$request->id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/categories/').'/'.$category->image))
            {
                File::delete(public_path('uploads/categories/').'/'.$category->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $filename =  Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateCategoryThumbnailsImages($image, $filename);
            $category->image = $filename;
        }
        
        $category->save();
        return redirect()->route('admin.categories')->with('status', 'Category has been updated successfully!');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if(File::exists(public_path('uploads/categories/').'/'.$category->image))
        {
            File::delete(public_path('uploads/categories/').'/'.$category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'Category has been deleted successfully!');
    }

    public function products()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }
    
    public function product_add()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'SKU' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'stock_status' => 'required|string|max:255',
            'featured' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailsImages($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if($request->hasFile('images')) {
            $allowedfileExtion = ['jpg','png','jpeg'];
            $files = $request->file('images');
            
            foreach($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                
                if($gcheck) {
                    $gfileName = $current_timestamp . '_' . $counter . '.' . $gextension;
                    $this->GenerateProductThumbnailsImages($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter + 1;
                }
            }
        $gallery_images = implode(',', $gallery_arr);

        }

        $product->images = $gallery_images;
        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product has been added successfully!');
    }

    public function GenerateProductThumbnailsImages($image, $imageName)
    {
        $destinationPath = public_path('uploads/products/');
        $destinationPathThumbnail = public_path('uploads/products/thumbnails/');
        $img = Image::read($image->path());

        $img->cover(540,689, "top");
        $img->resize(540,689, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);

        $img->resize(104,104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail.'/'.$imageName);
    }

    public function product_edit($id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    public function product_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'short_description' => 'required|string',
            'description' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'SKU' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'stock_status' => 'required|string|max:255',
            'featured' => 'required|boolean',
            'image' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $current_timestamp = Carbon::now()->timestamp;

        if($request->hasFile('image')) {
            if(File::exists(public_path('uploads/products/').'/'.$product->image))
            {
                File::delete(public_path('uploads/products/').'/'.$product->image);
            }
            if(File::exists(public_path('uploads/products/thumbnails/').'/'.$product->image))
            {
                File::delete(public_path('uploads/products/thumbnails/').'/'.$product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailsImages($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = array();
        $gallery_images = "";
        $counter = 1;

        if($request->hasFile('images')) {
            foreach(explode(',', $product->images) as $old_image)
            {
                if(File::exists(public_path('uploads/products/').'/'.$old_image))
                {
                    File::delete(public_path('uploads/products/').'/'.$old_image);
                }
                if(File::exists(public_path('uploads/products/thumbnails/').'/'.$old_image))
                {
                    File::delete(public_path('uploads/products/thumbnails/').'/'.$old_image);
                }
            }
            $allowedfileExtion = ['jpg','png','jpeg'];
            $files = $request->file('images');
            
            foreach($files as $file) {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedfileExtion);
                
                if($gcheck) {
                    $gfileName = $current_timestamp . '_' . $counter . '.' . $gextension;
                    $this->GenerateProductThumbnailsImages($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                    $counter = $counter + 1;
                }
            }
            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images;
        }

        $product->save();
        return redirect()->route('admin.products')->with('status', 'Product has been updated successfully!');
        
    }
    
    public function product_delete($id)
    {
        $product = Product::find($id);
        if(File::exists(public_path('uploads/products/').'/'.$product->image))
        {
            File::delete(public_path('uploads/products/').'/'.$product->image);
        }
        if(File::exists(public_path('uploads/products/thumbnails/').'/'.$product->image))
        {
            File::delete(public_path('uploads/products/thumbnails/').'/'.$product->image);
        }

        foreach(explode(',', $product->images) as $old_image)
        {
            if(File::exists(public_path('uploads/products/').'/'.$old_image))
            {
                File::delete(public_path('uploads/products/').'/'.$old_image);
            }
            if(File::exists(public_path('uploads/products/thumbnails/').'/'.$old_image))
            {
                File::delete(public_path('uploads/products/thumbnails/').'/'.$old_image);
            }
        }
        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Product has been deleted successfully!');
    }

    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(12);
        return view('admin.coupons', compact('coupons'));
    }

    public function coupon_add()
    {
        return view('admin.coupon-add');
    }

    public function coupon_store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Coupon has been added successfully!');
    }

    public function coupon_edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupon-edit', compact('coupon'));
    }
    
    public function coupon_update(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
        ]);

        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();
        return redirect()->route('admin.coupons')->with('status', 'Coupon has been updated successfully!');
    }

    public function coupon_delete($id)
    {
        $coupon = Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('status', 'Coupon has been deleted successfully!');
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id', 'DESC')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        return view('admin.order-details', compact('order', 'orderItems', 'transaction'));
    }

    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        
        if($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        
        $order->save();

        if($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }

        return back()->with("status", "Status changed successfully!");
    }

    public function slides(){
        $slides = Slide::orderBy('id', 'DESC')->paginate(12);
        return view('admin.slides', compact('slides'));
    }

    public function slide_add(){
        return view('admin.slide-add');
    }

    public function slide_store(Request $request){
        $request->validate([
            'tagline' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slide = new Slide();
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;
        
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp.'.'.$file_extention;
        $this->GenerateSlideThumbailsImage($image,$file_name);
        $slide->image = $file_name;
        $slide->save();
        return redirect()->route('admin.slides')->with('status', 'Slide has been added successfully!');
    }
        
    public function GenerateSlideThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/slides');
        $img = Image::read($image->path());
        $img->save($destinationPath.'/'.$imageName);
    }

    public function slide_edit($id){
        $slide = Slide::find($id);
        return view('admin.slide-edit', compact('slide'));
    }

    public function slide_update(Request $request){
        $request->validate([
            'tagline' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slide = Slide::find($request->id);
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if($request->hasFile('image')){
            if(File::exists(public_path('uploads/slides/').'/'.$slide->image)){
                File::delete(public_path('uploads/slides/').'/'.$slide->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp.'.'.$file_extention;
            $this->GenerateSlideThumbailsImage($image,$file_name);
            $slide->image = $file_name;
        }
        $slide->save();
        return redirect()->route('admin.slides')->with('status', 'Slide has been updated successfully!');
    }

    public function slide_delete($id){
        $slide = Slide::find($id);
        if(File::exists(public_path('uploads/slides/').'/'.$slide->image)){
            File::delete(public_path('uploads/slides/').'/'.$slide->image);
        }
        $slide->delete();
        return redirect()->route('admin.slides')->with('status', 'Slide has been deleted successfully!');
    }

    public function contacts(){
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.contacts', compact('contacts'));
    }

    public function contact_delete($id){
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->route('admin.contacts')->with('status', 'Contact has been deleted successfully!');
    }

    public function search_products(Request $request){
        $query = $request->input('query');
        $results = Product::where('name', 'like', "%{$query}%")->get()->take(10);
        return response()->json($results);
    }

    public function settings()
    {
        $settings = Setting::first();
        return view('admin.setting', compact('settings'));
    }

    public function settings_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'old_password' => 'required_with:new_password',
            'new_password' => 'required_with:old_password|min:8|confirmed',
        ]);

        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }

        $settings->name = $request->name;
        $settings->phone = $request->phone;
        $settings->email = $request->email;
        $settings->save();

        // Handle password change if provided
        if ($request->filled('old_password')) {
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return back()->withErrors(['old_password' => 'The old password is incorrect']);
            }

            auth()->user()->update([
                'password' => Hash::make($request->new_password)
            ]);
        }

        return redirect()->route('admin.settings')->with('status', 'Settings have been updated successfully!');
    }

    public function users()
    {
        $users = \App\Models\User::orderBy('created_at', 'DESC')->paginate(12);
        return view('admin.users', compact('users'));
    }

    public function user_delete($id)
    {
        $user = \App\Models\User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('admin.users')->with('status', 'User has been deleted successfully!');
        }
        return redirect()->route('admin.users')->with('error', 'User not found!');
    }
}
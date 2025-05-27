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


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
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
            'short_description' => 'required|string|max:255',
            'description' => 'required|string|max:255',
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
            'short_description' => 'required|string|max:255',
            'description' => 'required|string|max:255',
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

}
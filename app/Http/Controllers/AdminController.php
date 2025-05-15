<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

    public function GernerateBrandThumbnailsImages($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands/');
        $img = Image::read($image->path());
        $img->cover(124,124, "top");
        $img->resize(124,124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }
}
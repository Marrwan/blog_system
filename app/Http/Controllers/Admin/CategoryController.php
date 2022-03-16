<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::latest()->get();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        $image = $request->file('image');
        $slug = Str::slug($request->name);
        if (isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }

            $category = Image::make($image)->resize(1600, 479)->save($imageName,90);
            Storage::disk('public')->put('category/'.$imageName, $category);

            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }

            $slider = Image::make($image)->resize(500, 333)->save($imageName,90);
            Storage::disk('public')->put('category/slider/'.$imageName, $slider);
        } else {
            $imageName = 'defaultCategory.png';
        }
        $category = new Category;

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->image = $imageName;

        $category->save();

        Toastr::success('Category Successfully Created :) ' , 'Success');

        return  redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::find($id);

        return  view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
            'name' => 'required|unique:categories',
            'image' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

        $image = $request->file('image');
        $slug = Str::slug($request->name);
        $category = Category::find($id);
        if (isset($image)){
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }

            if (Storage::disk('public')->exists('category/'.$category->image)){
                Storage::disk('public')->delete('category/'.$category->image);
            }

            $categoryImage = Image::make($image)->resize(1600, 479)->save($imageName,90);
            Storage::disk('public')->put('category/'.$imageName, $categoryImage);

            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }

            if (Storage::disk('public')->exists('category/slider/'.$category->image)){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }

            $slider = Image::make($image)->resize(500, 333)->save($imageName,90);
            Storage::disk('public')->put('category/slider/'.$imageName, $slider);
        } else {
            $imageName = $category->image;
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->image = $imageName;

        $category->save();

        Toastr::success('Category Successfully Updated :) ' , 'Success');

        return  redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::find($id);
        if (Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }
        if (Storage::disk('public')->exists('category/slider/'.$category->image)){
        Storage::disk('public')->delete('category/slider/'.$category->image);
    }

        $category->delete();

        Toastr::success('Category Successfully deleted', 'Success');

        return  redirect()->back();
    }
}

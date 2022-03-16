<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::latest()->get();
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.create', compact('categories', 'tags'));
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
        $this->validate($request,[
            'title' => 'required',
            'tags' => 'required',
            'categories' => 'required',
            'body' => 'required',
            'image' => 'required'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->title);


        if (isset($image)){
//            Unique  name for image
            $imageName = $slug.'-'.Carbon::now()->toDateString().'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('post')){
                Storage::disk('public')->makeDirectory('post');
            }


            $postImage = Image::make($image)->resize('1600', '1066')->save($imageName,90);
            Storage::disk('public')->put('post/'.$imageName,$postImage);
        } else {
            $imageName = 'defaultPost.png';

        }
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->image = $imageName;
        $post->slug = $slug;
        $post->status = isset($request->status);
        $post->is_approved = true;

        $post->save();

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        Toastr::success('A New Post has been successfully created');

        return redirect()->route('admin.post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //

        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit', compact('post','categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        $this->validate($request,[
            'title' => 'required',
            'tags' => 'required',
            'categories' => 'required',
            'body' => 'required',
            'image' => 'image'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->title);


        if (isset($image)){
//            Unique  name for image
            $imageName = $slug.'-'.Carbon::now()->toDateString().'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //  Create a directory for the image

            if (!Storage::disk('public')->exists('post')){
                Storage::disk('public')->makeDirectory('post');
            }
          
            // delete existing image if exists

            if(Storage::disk('public')->exists('post/'.$post->image)){ 
                Storage::disk('public')->delete('post/'.$post->image);
            }

            $postImage = Image::make($image)->resize('1600', '1066')->save($imageName,90);
            Storage::disk('public')->put('post/'.$imageName,$postImage);
        } else {
            $imageName = $post->image;

        }
        
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->image = $imageName;
        $post->slug = $slug;
        $post->status = isset($request->status);
        $post->is_approved = true;

        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        Toastr::success('Post has been successfully Updated');

        return redirect()->route('admin.post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}

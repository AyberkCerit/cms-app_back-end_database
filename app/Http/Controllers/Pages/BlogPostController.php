<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Classes\BlogPostClass;
use App\Models\BlogCategory;

class BlogPostController extends Controller
{
    public function index(){
        return view('pages.blog.posts.index');
    }

    public function getData()
    {
        $class = new BlogPostClass();
        return $class->getData();
    }

    public function new()
    {
        $post = null;
        $categories = \App\Models\BlogCategory::all();
        $languages = \App\Models\Language::where('status', 1)->get();
        return view('pages.blog.posts.detail', compact('post', 'categories', 'languages'));
    }

    public function preview($id){
        $post = \App\Models\BlogPost::findOrFail($id);
        return view('pages.blog.posts.preview', compact('post'));
    }

    public function edit($param){
        $post = \App\Models\BlogPost::find($param);

        if($post == null){
            return redirect()->route('blog-posts');
        }

        if (!Auth::user()->hasRole('Admin') && $post->user_id != Auth::id()) {
            abort(403, 'Yetkisiz erişim. Sadece kendi yazılarınızı düzenleyebilirsiniz.');
        }

        $categories = \App\Models\BlogCategory::all();
        $languages = \App\Models\Language::where('status', 1)->get();
        return view('pages.blog.posts.detail', compact('post', 'categories', 'languages'));
    }

    public function savePost(\Illuminate\Http\Request $request)
    {
        $class = new BlogPostClass();
        return response()->json($class->savePost());
    }

    public function toggleStatus()
    {
        $class = new BlogPostClass();
        return response()->json($class->toggleStatus());
    }

    public function deletePost()
    {
        $class = new BlogPostClass();
        return response()->json($class->deletePost());
    }
}

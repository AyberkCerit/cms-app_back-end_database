<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Classes\BlogCategoryClass;

class BlogCategoryController extends Controller
{
    public function index(){
        return view('pages.blog.categories.index');
    }

    public function getData()
    {
        $class = new BlogCategoryClass();
        return $class->getData();
    }

    public function new()
    {
        $category = null;
        $languages = \App\Models\Language::where('status', 1)->get();
        return view('pages.blog.categories.detail', compact('category', 'languages'));
    }

    public function edit($param){
        $category = \App\Models\BlogCategory::find($param);

        if($category == null){
            return redirect()->route('blog-categories');
        }

        $languages = \App\Models\Language::where('status', 1)->get();
        return view('pages.blog.categories.detail', compact('category', 'languages'));
    }

    public function saveCategory(\Illuminate\Http\Request $request)
    {
        $class = new BlogCategoryClass();
        return response()->json($class->saveCategory());
    }

    public function deleteCategory()
    {
        $class = new BlogCategoryClass();
        return response()->json($class->deleteCategory());
    }
}

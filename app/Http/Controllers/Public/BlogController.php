<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = BlogPost::with(['category', 'category.translations', 'author', 'translations'])
                    ->where('status', 1);

        if ($request->has('category')) {
            $catSlug = $request->get('category');
            $category = BlogCategory::where('slug', $catSlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(9);

        $categories = Cache::remember('active_blog_categories', 3600, function () {
            return BlogCategory::with('translations')->where('status', 1)->get();
        });

        return view('public.blog.index', compact('posts', 'categories'));
    }

    public function detail($slug)
    {
        $post = BlogPost::with(['category', 'category.translations', 'author', 'translations'])
                    ->where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();

        // Increment view count
        $post->increment('view_count');

        $categories = Cache::remember('active_blog_categories', 3600, function () {
            return BlogCategory::with('translations')->where('status', 1)->get();
        });

        return view('public.blog.detail', compact('post', 'categories'));
    }
}

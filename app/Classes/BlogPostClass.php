<?php

namespace App\Classes;

use App\Models\BlogPost;
use App\Models\BlogPostTranslation;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class BlogPostClass
{
    public function getData(){
        try {
            $query = BlogPost::with('category', 'translations', 'category.translations')->select('blog_posts.*');
            return DataTables::eloquent($query)
            ->addColumn('post_title', function($post){
                return $post->title_translated;
            })
            ->addColumn('category_name', function($post){
                return $post->category ? $post->category->name_translated : 'Kategori Yok';
            })
            ->addColumn('status_name', function($post){
                return $post->status == 1 ? "Active" : "Passive";
            })
            ->addColumn('action', function($post){
                $buttons = "<div class='d-flex flex-column flex-md-row gap-2'>" .
                           "<a href=".route('blog-posts.preview', [$post->id])." class='btn btn-outline-secondary min-btn-table flex-fill text-nowrap'>Gözat</a>";

                if (Auth::user()->hasRole('Admin') || $post->user_id == Auth::id()) {
                    $toggleText = $post->status == 1 ? "Pasif Yap" : "Aktif Yap";
                    $toggleBtnClass = $post->status == 1 ? "btn-warning" : "btn-info";
                    $buttons .= "<a href=".route('blog-posts.edit', [$post->id])." class='btn btn-success min-btn-table flex-fill text-nowrap'>Edit</a>" .
                                "<button class='btn $toggleBtnClass min-btn-table togglePostBtn flex-fill text-nowrap' data-id='".$post->id."'>$toggleText</button>" .
                                "<button class='btn btn-danger min-btn-table deletePostBtn flex-fill text-nowrap' data-id='".$post->id."'>Delete</button>";
                }
                
                $buttons .= "</div>";
                return $buttons;
            })
            ->filterColumn('post_title', function($query, $keyword) {
                $locale = app()->getLocale();
                $query->whereHas('translations', function($q) use ($locale, $keyword) {
                    $q->where('locale', $locale)->where('title', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('category_name', function($query, $keyword) {
                $locale = app()->getLocale();
                $query->whereHas('category', function($q) use ($locale, $keyword) {
                    $q->whereHas('translations', function($q2) use ($locale, $keyword) {
                        $q2->where('locale', $locale)->where('name', 'like', "%{$keyword}%");
                    });
                });
            })
            ->setRowAttr([
                'data-id' => function($post){
                    return $post->id;
                }
            ])
            ->make(true);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function savePost(){
        try {
            $titleJson = request()->get('title');
            $titleData = json_decode($titleJson, true);
            $primaryTitle = $titleData[config('app.fallback_locale', 'en')] ?? current($titleData);
            
            $summaryJson = request()->get('summary');
            $summaryData = json_decode($summaryJson, true);
            
            $contentJson = request()->get('content');
            $contentData = json_decode($contentJson, true);

            $category_id = request()->get('category_id');
            $image = request()->get('image'); // Can be a URL for now
            $status = request()->get('status');
            $status = ($status == 'active') ? 1 : 0;
            $post_id = request()->get('post_id');

            if (empty($titleData) || $category_id == null || empty($contentData)) {
                return ['status' => false, 'message' => "Title, Category and Content are required"];
            }

            $slug = \Illuminate\Support\Str::slug($primaryTitle);

            if ($post_id == null) {
                $check = BlogPost::where('slug', $slug)->first();
                if ($check) {
                    return ['status' => false, 'message' => "Post slug already exists"];
                }
                $post = new BlogPost();
                $post->user_id = Auth::id(); // Set the author
            } else {
                $post = BlogPost::find($post_id);
                if ($post == null) {
                    return ['status' => false, 'message' => "Post not found"];
                }
                
                if (!Auth::user()->hasRole('Admin') && $post->user_id != Auth::id()) {
                    return ['status' => false, 'message' => "Unauthorized. You can only edit your own posts."];
                }

                $check = BlogPost::where('slug', $slug)->where('id', '!=', $post_id)->first();
                if ($check) {
                    return ['status' => false, 'message' => "Post slug already exists"];
                }
            }

            $post->category_id = $category_id;
            $post->image = $image;
            $post->slug = $slug;
            $post->status = $status;

            if ($post->save()) {
                // Save translations
                $post->translations()->delete(); // clear existing translations
                
                foreach ($titleData as $locale => $title) {
                    $summary = $summaryData[$locale] ?? null;
                    $content = $contentData[$locale] ?? null;
                    
                    if (!empty($title)) {
                        BlogPostTranslation::create([
                            'blog_post_id' => $post->id,
                            'locale' => $locale,
                            'title' => $title,
                            'summary' => $summary,
                            'content' => $content
                        ]);
                    }
                }
                
                return ['status' => true, 'message' => "Post saved successfully"];
            } else {
                return ['status' => false, 'message' => "Post not saved successfully"];
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "An error occurred during post save: " . $th->getMessage()];
        }
    }

    public function deletePost(){
        try {
            $id = request()->get('id');
            if ($id == null) {
                return ['status' => false, 'message' => "Post ID is required"];
            }
            $post = BlogPost::find($id);
            if ($post == null) {
                return ['status' => false, 'message' => "Post not found"];
            }

            if (!Auth::user()->hasRole('Admin') && $post->user_id != Auth::id()) {
                return ['status' => false, 'message' => "Unauthorized. You can only delete your own posts."];
            }

            if ($post->delete()) {
                return ['status' => true, 'message' => "Post deleted successfully"];
            } else {
                return ['status' => false, 'message' => "Failed to delete post"];
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "An error occurred during post deletion"];
        }
    }
    public function toggleStatus(){
        try {
            $id = request()->get('id');
            if ($id == null) {
                return ['status' => false, 'message' => "Post ID is required"];
            }
            $post = BlogPost::find($id);
            if ($post == null) {
                return ['status' => false, 'message' => "Post not found"];
            }

            if (!Auth::user()->hasRole('Admin') && $post->user_id != Auth::id()) {
                return ['status' => false, 'message' => "Unauthorized. You can only toggle your own posts."];
            }

            $post->status = $post->status == 1 ? 0 : 1;
            if ($post->save()) {
                $statusName = $post->status == 1 ? 'Aktif' : 'Pasif';
                return ['status' => true, 'message' => "Yazı durumu $statusName olarak güncellendi"];
            } else {
                return ['status' => false, 'message' => "Durum güncellenemedi"];
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "Hata oluştu"];
        }
    }
}

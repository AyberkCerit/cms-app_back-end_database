<?php

namespace App\Classes;

use App\Models\BlogCategory;
use App\Models\BlogCategoryTranslation;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryClass
{
    public function getData(){
        try {
            $query = BlogCategory::with('translations')->select('blog_categories.*');
            return DataTables::eloquent($query)
            ->addColumn('category_name', function($category){
                return $category->name_translated;
            })
            ->addColumn('status_name', function($category){
                return $category->status == 1 ? "Active" : "Passive";
            })
            ->addColumn('action', function($category){
                return "<div class='d-flex flex-column flex-md-row gap-2'>" .
                       "<a href=".route('blog-categories.edit', [$category->id])." class='btn btn-success min-btn-table flex-fill text-nowrap'>Edit</a>" .
                       "<button class='btn btn-danger min-btn-table deleteCategoryBtn flex-fill text-nowrap' data-id='".$category->id."'>Delete</button>" .
                       "</div>";
            })
            ->filterColumn('category_name', function($query, $keyword) {
                $locale = app()->getLocale();
                $query->whereHas('translations', function($q) use ($locale, $keyword) {
                    $q->where('locale', $locale)->where('name', 'like', "%{$keyword}%");
                });
            })
            ->setRowAttr([
                'data-id' => function($category){
                    return $category->id;
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

    public function saveCategory(){
        try {
            $nameJson = request()->get('name');
            $nameData = json_decode($nameJson, true);
            $primaryName = $nameData[config('app.fallback_locale', 'en')] ?? current($nameData);
            
            $status = request()->get('status');
            $status = ($status == 'active') ? 1 : 0;
            $category_id = request()->get('category_id');

            if (empty($nameData)) {
                return ['status' => false, 'message' => "Category Name is required"];
            }

            $slug = \Illuminate\Support\Str::slug($primaryName);

            if ($category_id == null) {
                $check = BlogCategory::where('slug', $slug)->first();
                if ($check) {
                    return ['status' => false, 'message' => "Category Name already exists"];
                }
                $category = new BlogCategory();
            } else {
                $category = BlogCategory::find($category_id);
                if ($category == null) {
                    return ['status' => false, 'message' => "Category not found"];
                }
                $check = BlogCategory::where('slug', $slug)->where('id', '!=', $category_id)->first();
                if ($check) {
                    return ['status' => false, 'message' => "Category Name already exists"];
                }
            }

            $category->slug = $slug;
            $category->status = $status;

            if ($category->save()) {
                // Save translations
                $category->translations()->delete();
                
                foreach ($nameData as $locale => $name) {
                    if (!empty($name)) {
                        BlogCategoryTranslation::create([
                            'blog_category_id' => $category->id,
                            'locale' => $locale,
                            'name' => $name
                        ]);
                    }
                }
                return ['status' => true, 'message' => "Category saved successfully"];
            } else {
                return ['status' => false, 'message' => "Category not saved successfully"];
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "An error occurred during category save"];
        }
    }

    public function deleteCategory(){
        try {
            $id = request()->get('id');
            if ($id == null) {
                return ['status' => false, 'message' => "Category ID is required"];
            }
            $category = BlogCategory::find($id);
            if ($category == null) {
                return ['status' => false, 'message' => "Category not found"];
            }
            if ($category->delete()) {
                return ['status' => true, 'message' => "Category deleted successfully"];
            } else {
                return ['status' => false, 'message' => "Failed to delete category"];
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "An error occurred during category deletion"];
        }
    }
}

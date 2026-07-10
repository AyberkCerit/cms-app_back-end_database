<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['blog_category_id', 'locale', 'name'];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}

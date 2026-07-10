<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['blog_post_id', 'locale', 'title', 'summary', 'content'];

    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }
}

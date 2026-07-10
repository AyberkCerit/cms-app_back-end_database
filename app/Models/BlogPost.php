<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'slug',
        'image',
        'status',
        'view_count',
    ];

    public function translations()
    {
        return $this->hasMany(BlogPostTranslation::class);
    }

    public function translate($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            $translation = $this->translations->where('locale', config('app.fallback_locale'))->first();
        }
        if (!$translation) {
            $translation = $this->translations->first();
        }
        return $translation;
    }

    public function getTitleTranslatedAttribute()
    {
        return $this->translate()?->title ?? '';
    }

    public function getSummaryTranslatedAttribute()
    {
        return $this->translate()?->summary ?? '';
    }

    public function getContentTranslatedAttribute()
    {
        return $this->translate()?->content ?? '';
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'status'];

    public function translations()
    {
        return $this->hasMany(BlogCategoryTranslation::class);
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

    public function getNameTranslatedAttribute()
    {
        return $this->translate()?->name ?? '';
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }
}

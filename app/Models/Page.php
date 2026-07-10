<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    
    protected $fillable = ['slug', 'status'];

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function getTitleTranslatedAttribute()
    {
        $locale = app()->getLocale();
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            $translation = $this->translations->first();
        }
        return $translation ? $translation->title : '';
    }

    public function getContentTranslatedAttribute()
    {
        $locale = app()->getLocale();
        $translation = $this->translations->where('locale', $locale)->first();
        if (!$translation) {
            $translation = $this->translations->first();
        }
        return $translation ? $translation->content : '';
    }
}

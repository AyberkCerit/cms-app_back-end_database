<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Classes\LanguageClass;

class LanguageController extends Controller
{
    public function index(){
        $class = new LanguageClass();
        $languages = $class->getLanguages();
        return view('pages.languages.index', compact('languages'));
    }

    public function switchLang($locale)
    {
        if (\App\Models\Language::where('code', $locale)->where('status', 1)->exists()) {
            session()->put('locale', $locale);
            
            if (\Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $user->locale = $locale;
                $user->save();
            }
        }
        return redirect()->back();
    }

    public function toggleStatus()
    {
        $class = new LanguageClass();
        return response()->json($class->toggleStatus());
    }

    public function saveLanguage(\Illuminate\Http\Request $request)
    {
        $class = new LanguageClass();
        return response()->json($class->saveLanguage());
    }

    public function deleteLanguage()
    {
        $class = new LanguageClass();
        return response()->json($class->deleteLanguage());
    }
}

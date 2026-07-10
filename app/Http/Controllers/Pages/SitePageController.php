<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\PageTranslation;
use App\Models\Language;
use Illuminate\Support\Str;

class SitePageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->get();
        return view('pages.site_pages.index', compact('pages'));
    }

    public function form($id = null)
    {
        $page = $id ? Page::findOrFail($id) : null;
        $languages = Language::where('status', 1)->get();
        return view('pages.site_pages.form', compact('page', 'languages'));
    }

    public function save(Request $request)
    {
        $id = $request->id;
        if($id) {
            $page = Page::find($id);
            $page->status = $request->status == 'active' ? 1 : 0;
            $page->save();
        } else {
            $defaultLang = Language::first()->code ?? 'tr';
            $title = $request->title[$defaultLang] ?? current($request->title);
            $slug = Str::slug($title);
            
            if(Page::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . time();
            }

            $page = Page::create([
                'slug' => $slug,
                'status' => $request->status == 'active' ? 1 : 0
            ]);
        }

        foreach($request->title as $locale => $title) {
            if(!empty($title)) {
                PageTranslation::updateOrCreate(
                    ['page_id' => $page->id, 'locale' => $locale],
                    [
                        'title' => $title,
                        'content' => $request->content[$locale] ?? ''
                    ]
                );
            }
        }

        return redirect()->route('pages.index')->with('success', 'Sayfa başarıyla kaydedildi.');
    }

    public function delete($id)
    {
        $page = Page::findOrFail($id);
        $page->translations()->delete();
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Sayfa silindi.');
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('pages.public_page', compact('page'));
    }
}

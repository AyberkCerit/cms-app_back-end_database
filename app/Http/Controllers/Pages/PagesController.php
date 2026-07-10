<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PagesController
{
    public function index(){
        $recentPosts = \App\Models\BlogPost::with(['translations', 'author', 'category.translations'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        $postCount = \App\Models\BlogPost::count();
        $userCount = \App\Models\User::count();
        $categoryCount = \App\Models\BlogCategory::count();

        return view('pages.dashboard', compact('recentPosts', 'postCount', 'userCount', 'categoryCount'));
    }

    public function upgrade(){
        return view('pages.upgrade');
    }

    public function profile(){
        return view('pages.profile');
    }

    public function updateProfile(Request $request){
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil başarıyla güncellendi.');
    }
}

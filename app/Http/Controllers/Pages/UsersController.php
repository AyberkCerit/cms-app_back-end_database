<?php

namespace App\Http\Controllers\Pages;
use App\Classes\UsersClass;
use Illuminate\Support\Facades\Auth;

class UsersController
{
    public function index(){
        if (!Auth::user()->hasRole('Admin')) abort(403);
        return view('pages.users.index');
    }
     public function getData()
    {
        $class = new UsersClass();
        return $class->getData();
    }

    public function new()
    {
        if (!Auth::user()->hasRole('Admin')) abort(403);
        $user = null;
        return view('pages.users.detail', compact('user'));
    }
    public function saveUser(\Illuminate\Http\Request $request)
{
    $class = new UsersClass();
    return $class->saveUser($request);
}

public function edit($param){
    if (!Auth::user()->hasRole('Admin')) abort(403);
    $user = \App\Models\User::find($param);

    if($user == null){
    return redirect()->route('users');
    }

    view()->share('user',$user);


    return view('pages.users.detail', compact('user'));
}

    public function deleteUser()
    {
        $class = new UsersClass();
        return response()->json($class->deleteUser());
    }
}

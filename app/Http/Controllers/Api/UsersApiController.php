<?php

namespace App\Http\Controllers\Api;
use App\Classes\UsersClass;
use App\Classes\LoginClass;

class UsersApiController
{
    public function getData(){
        $class = new UsersClass();
        return $class->getData();
    }
    public function saveUser(){
        $class = new UsersClass();
        return response()->json($class->saveUser());
    }

}

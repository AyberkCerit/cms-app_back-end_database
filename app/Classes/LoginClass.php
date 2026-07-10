<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LoginClass
{
    public function login()
    {
        try {
            $email = request()->get('email');
            $password = request()->get('password');

            if ($email == null) {
                return [
                    'status' => false,
                    'message' => 'Lütfen e-posta adresinizi giriniz'
                ];
            }

            if ($password == null) {
                return [
                    'status' => false,
                    'message' => 'Lütfen şifrenizi giriniz'
                ];
            }

            $user = User::where('email', $email)->first();

            if ($user == null) {
                return [
                    'status' => false,
                    'message' => 'Kullanıcı bulunamadı'
                ];
            }

            if (!Hash::check($password, $user->password)) {
                return [
                    'status' => false,
                    'message' => 'Şifre yanlış'
                ];
            }

            FacadesAuth::login($user);

            if (FacadesAuth::check()) {
                return ["status" => true, "message" => "Success"];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 'Login failed'
            ];
        }
    }
}
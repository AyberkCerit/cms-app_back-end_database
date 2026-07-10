<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class RegisterClass
{
    public function register()
    {
        try {
            $name = request()->get('name');
            $email = request()->get('email');
            $password = request()->get('password');
            $password_confirmation = request()->get('password_confirmation');

            if ($name == null) {
                return ['status' => false, 'message' => 'Please enter your full name.'];
            }
            if ($email == null) {
                return ['status' => false, 'message' => 'Please enter your email address.'];
            }
            if ($password == null) {
                return ['status' => false, 'message' => 'Please enter your password.'];
            }
            if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
                return [
                    'status' => false, 
                    'message' => 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
                ];
            }
            if ($password !== $password_confirmation) {
                return ['status' => false, 'message' => 'Passwords do not match.'];
            }

            if (User::where('email', $email)->exists()) {
                return ['status' => false, 'message' => 'This email address is already in use.'];
            }

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password)
            ]);

            // Assign a default role
            $user->assignRole('Yazar'); // using Spatie Permission

            FacadesAuth::login($user);

            if (FacadesAuth::check()) {
                return ["status" => true, "message" => "Registration successful, redirecting..."];
            }
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 'An error occurred during registration: ' . $th->getMessage()
            ];
        }
    }
}

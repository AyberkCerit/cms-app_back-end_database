<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Container\Attributes\Auth;
use Yajra\DataTables\Facades\DataTables;


class UsersClass
{
    public function getData(){
        try {
            $data=User::all();
            return DataTables::of($data)
            ->addColumn('status_name',function($user){
                if($user->status==1){
                    return "Active";
                }
                else{
                    return "Passive";
                }
            })
            ->addColumn('action',function($user){
                return "<div class='d-flex flex-column flex-md-row gap-2'>" .
                       "<a href=".route('users/edit',[$user->id])." class='btn btn-success min-btn-table flex-fill text-nowrap'>Edit</a>" .
                       "<button class='btn btn-danger min-btn-table deleteUserBtn flex-fill text-nowrap' data-id='".$user->id."'>Delete</button>" .
                       "</div>";
            })
            ->setRowAttr([
                'data-id'=>function($user){
                    return $user->id;
                }
            ])
            ->make(true);
        } catch (\Throwable $th) {
            return response()->json([
            'status'=>'error',
            'message'=>$th->getMessage()
        ]);
        }
    }
    public function saveUser(){
    try {
        if (!FacadesAuth::user()->hasRole('Admin')) {
            return ['status'=>false,'message'=>"Yetkisiz işlem. Sadece yöneticiler bu işlemi yapabilir."];
        }

        $name_surname=request()->get('name_surname');
        $email=request()->get('email');
        $phone=request()->get('phone');
        $password=request()->get('password');
        $password_rep=request()->get('password_rep');
        $status=request()->get('status');
        $status = ($status == 'active') ? 1 : 0;
        $user_id=request()->get('user_id');

        if($name_surname==null){
            return ['status'=>false,'message'=>"Name Surname is required"];
        }
        if($email==null){
            return ['status'=>false,'message'=>"Email is required"];
        }

        if($user_id==null){
            // YENİ KULLANICI
            $mailCheck=User::where('email',$email)->first();
            if($mailCheck){
                return ['status'=>false,'message'=>"Email already exists"];
            }
            if($password==null){
                return ['status'=>false,'message'=>"Password is required"];
            }
            if($password_rep==null){
                return ['status'=>false,'message'=>"Password Repeat is required"];
            }
            if($password!=$password_rep){
                return ['status'=>false,'message'=>"Password and Password Repeat is not equal"];
            }
            $user=new User();
            $user->create_user_id=FacadesAuth::user()->id;
            $user->updated_at=null;
            $user->password=Hash::make($password);
        }else{
            // GÜNCELLEME
            $user=User::find($user_id);
            $user->update_user_id=FacadesAuth::user()->id;
            $user->updated_at=Carbon::now();

            if($user==null){
                return ['status'=>false,'message'=>"User not found"];
            }
            if($password!=null){
                if($password_rep==null){
                    return ['status'=>false,'message'=>"Password Repeat is required"];
                }
                if($password!=$password_rep){
                    return ['status'=>false,'message'=>"Password and Password Repeat is not equal"];
                }
                $user->password=Hash::make($password);
            }
        }

        $user->name=$name_surname;
        $user->email=$email;
        $user->phone=$phone;
        $user->status=$status;

        if($user->save()){
            return ['status'=>true,'message'=>"User saved successfully"];
        }else{
            return ['status'=>false,'message'=>"User not saved successfully"];
        }
    } catch (\Throwable $th) {
        return ['status'=>false,'message'=>"A error occurred during user save"];
    }
    }
    public function deleteUser(){
        try {
            if (!FacadesAuth::user()->hasRole('Admin')) {
                return ['status'=>false,'message'=>"Yetkisiz işlem. Sadece yöneticiler kullanıcı silebilir."];
            }

            $id = request()->get('id');
            if ($id == null) {
                return ['status' => false, 'message' => "User ID is required"];
            }
            $user = User::find($id);
            if ($user == null) {
                return ['status' => false, 'message' => "User not found"];
            }
            if ($user->delete()) {
                return ['status' => true, 'message' => "User deleted successfully"];
            } else {
                return ['status' => false, 'message' => "Failed to delete user"];
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "An error occurred during user deletion"];
        }
    }
}

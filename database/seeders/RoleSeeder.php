<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temel rolleri oluştur
        $adminRole = Role::create(['name' => 'Admin']);
        $authorRole = Role::create(['name' => 'Yazar']);

        // İzinler eklenebilir
        // $permission = Permission::create(['name' => 'edit articles']);
        // $adminRole->givePermissionTo($permission);

        // Sistemdeki ilk kullanıcıyı Admin yap (eğer varsa)
        $user = User::first();
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}

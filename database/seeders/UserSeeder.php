<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin
        $role = Role::where('name', 'Admin')->first();
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'role_id' => $role->id,
                'password' => Hash::make('12345678'),
                'email_verified_at' => now()
            ]
        );
        $adminPermission = Permission::whereIn('permission', ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])->pluck('id')->all();
        $admin->syncPermissions($adminPermission);

        //user
        $role = Role::where('name', 'Editor')->first();
        $user = User::updateOrCreate(
            [
                'email' => 'editor@editor.com',
            ],
            [
                'name' => 'Editor',
                'role_id' => $role->id,
                'password' => Hash::make(12345678),
                'email_verified_at' => now()
            ]
        );
        $userPermission = Permission::whereIn('permission', ['index', 'create', 'store', 'show', 'edit', 'update'])->pluck('id')->all();
        $user->syncPermissions($userPermission);

        //Viewer
        $role = Role::where('name', 'Viewer')->first();
        $user = User::updateOrCreate(
            [
                'email' => 'viewer@viewer.com',
            ],
            [
                'name' => 'Viewer',
                'role_id' => $role->id,
                'password' => Hash::make(12345678),
                'email_verified_at' => now()
            ]
        );
        $userPermission = Permission::whereIn('permission', ['index', 'show'])->pluck('id')->all();
        $user->syncPermissions($userPermission);
    }

}

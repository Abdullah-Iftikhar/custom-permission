<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionNames = [
            'users',
            'blog',
            'payment',
        ];
        $permissions = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];

        foreach ($permissionNames as $permissionName) {
            foreach ($permissions as $permission) {
                Permission::updateOrCreate([
                    'name' => $permissionName,
                    'permission' => $permission,
                ]);
            }
        }
    }
}

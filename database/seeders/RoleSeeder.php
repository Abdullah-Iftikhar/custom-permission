<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            'Admin',
            'Editor',
            'Viewer',
        ];

        foreach ($array as $key => $row) {
            Role::updateOrCreate(
                ['name'=> $row]
            );
        }
    }
}

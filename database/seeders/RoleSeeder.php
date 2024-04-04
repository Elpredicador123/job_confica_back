<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'description' => 'ADMINISTRADOR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'description' => 'PROMOTOR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];  

        Role::insert($roles);
        Role::where('description','ADMINISTRADOR')->first()->permissions()->attach(Permission::whereNotIn('id',[])->pluck('id'));
        Role::where('description','PROMOTOR')->first()->permissions()->attach(Permission::whereNotIn('id',[])->pluck('id'));
    }
}

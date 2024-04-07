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
            [
                'description' => 'CREADOR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'description' => 'VISUALIZADOR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];  
        //GRAFICOS 
        //1,2,3,4,10
        //MANTENEDORES
        //5,6,7,8,9,11,12,13,14,15,16
        //crear
        //6,8,12,14,16
        $promotor = ['PRINCIPAL','MANAGEMENT','PROVISION','MAINTENANCE','QUALITY'];
        $visutalizador = ['L_NEWS','NEWS','L_BIRTHDAY','BIRTHDAY','L_RESERVATION','RESERVATION','L_INFOGRAPHIC','INFOGRAPHIC','L_ORDER','ORDER','L_TECHNICAL','TECHNICAL','L_USER','USER'
    ];

        Role::insert($roles);
        Role::where('description','ADMINISTRADOR')->first()->permissions()->attach(Permission::whereNotIn('key',[])->pluck('id'));
        Role::where('description','PROMOTOR')->first()->permissions()->attach(Permission::whereIn('key', $promotor)->pluck('id'));
        Role::where('description','CREADOR')->first()->permissions()->attach(Permission::whereNotIn('key', $promotor)->pluck('id'));
        Role::where('description','VISUALIZADOR')->first()->permissions()->attach(Permission::whereIn('key', $visutalizador)->pluck('id'));
    }
}

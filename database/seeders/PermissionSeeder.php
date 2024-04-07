<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'key' => 'L_NEWS',
                'description' => 'ACCESO A LA LISTA DE NOTICIAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_NEWS',
                'description' => 'ACCESO A LA CREACIÓN DE NOTICIAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'NEWS',
                'description' => 'ACCESO A MODULO DE NOTICIAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'L_BIRTHDAY',
                'description' => 'ACCESO A LA LISTA DE CUMPLEAÑOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_BIRTHDAY',
                'description' => 'ACCESO A LA CREACIÓN DE CUMPLEAÑOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'BIRTHDAY',
                'description' => 'ACCESO A MODULO DE CUMPLEAÑOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'L_RESERVATION',
                'description' => 'ACCESO A LA LISTA DE RESERVAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_RESERVATION',
                'description' => 'ACCESO A LA CREACIÓN DE RESERVAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'RESERVATION',
                'description' => 'ACCESO A MODULO DE RESERVAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'CONTROL_PANEL',
                'description' => 'ACCESO AL PANEL DE CONTROL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'PRINCIPAL',
                'description' => 'ACCESO A LA PÁGINA PRINCIPAL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'MANAGEMENT',
                'description' => 'ACCESO AL MODULO DE GESTIÓN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'PROVISION',
                'description' => 'ACCESO AL MODULO DE PROVISION',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'MAINTENANCE',
                'description' => 'ACCESO AL MODULO DE MANTENIMIENTO',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'QUALITY',
                'description' => 'ACCESO AL MODULO DE CALIDAD',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'L_INFOGRAPHIC',
                'description' => 'ACCESO A LA LISTA DE INFOGRAFÍAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_INFOGRAPHIC',
                'description' => 'ACCESO A LA CREACIÓN DE INFOGRAFÍAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'INFOGRAPHIC',
                'description' => 'ACCESO A MODULO DE INFOGRAFÍAS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'L_VIDEO',
                'description' => 'ACCESO A LA LISTA DE VIDEOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_VIDEO',
                'description' => 'ACCESO A LA CREACIÓN DE VIDEOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'VIDEO',
                'description' => 'ACCESO AL MODULO DE VIDEOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'L_ORDER',
                'description' => 'ACCESO A LA LISTA DE ORDENES',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_ORDER',
                'description' => 'ACCESO A LA CREACIÓN DE ORDENES',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'ORDER',
                'description' => 'ACCESO AL MODULO DE ORDENES',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'L_TECHNICAL',
                'description' => 'ACCESO A LA LISTA DE TÉCNICOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_TECHNICAL',
                'description' => 'ACCESO A LA CREACIÓN DE TÉCNICOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'TECHNICAL',
                'description' => 'ACCESO AL MODULO DE TÉCNICOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'L_USER',
                'description' => 'ACCESO A LA LISTA DE USUARIOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'C_USER',
                'description' => 'ACCESO A LA CREACIÓN DE USUARIOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'key' => 'USER',
                'description' => 'ACCESO AL MODULO DE USUARIOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];

        Permission::insert($permission);

    }
}

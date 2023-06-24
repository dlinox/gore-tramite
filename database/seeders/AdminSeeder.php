<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */




    public function run(): void
    {

        Role::create(['name' => 'Super Admin', 'guard_name' => 'admin', 'route_redirect' => '/a']);

        $admin = Role::create(['name' => 'Mesa de partes', 'guard_name' => 'admin', 'route_redirect' => '/a']);

        Permission::create(['name' => 'menu-de-expedientes', 'guard_name' => 'admin']);
        Permission::create(['name' => 'menu-de-consultas', 'guard_name' => 'admin']);
        Permission::create(['name' => 'menu-de-reportes', 'guard_name' => 'admin']);
        $admin->syncPermissions(['menu-de-expedientes', 'menu-de-consultas', 'menu-de-reportes']);

        $superAdmin =  Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'ofic_id' => 1,
            'pers_id' => 1,
            'ofic_name' => 'OTI',
            'rol_name' => 'Administrador',
            'active' => true,
        ]);

        $superAdmin->assignRole('Super Admin');

        $mesa = Admin::create([
            'name' => 'Mesa User',
            'email' => 'mesa@gmail.com',
            'password' => 'password',
            'ofic_id' => 2,
            'pers_id' => 2,
            'ofic_name' => 'MESA DE PARTES',
            'rol_name' => 'Mesa de partes',
            'active' => true,
        ]);

        $mesa->assignRole('Mesa de partes');
    }
}

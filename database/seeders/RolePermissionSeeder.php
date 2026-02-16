<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::where('name','admin')->first();
        $almacen = Role::where('name','almacen')->first();
        $operativo = Role::where('name','operativo')->first();
        $supervisor = Role::where('name','supervisor')->first();
        $compras = Role::where('name','compras')->first();
        $auditor = Role::where('name','auditor')->first();

        $admin->permissions()->sync(Permission::pluck('id'));

        $almacen->permissions()->sync(
            Permission::whereIn('name', [
                'view_products','create_products','edit_products',
                'view_entries','create_entries',
                'view_exits','create_exits',

                // SOLICITUDES
                'solicitudes.view',
                'solicitudes.deliver',
            ])->pluck('id')
        );

        $operativo->permissions()->sync(
            Permission::whereIn('name', [
                'view_products','create_exits',

                // SOLICITUDES
                'solicitudes.create',
                'solicitudes.view',
            ])->pluck('id')
        );

        $supervisor->permissions()->sync(
            Permission::whereIn('name', [
                'view_products','view_entries','approve_entries',
                'view_exits','approve_exits',
                'view_reports',

                // SOLICITUDES
                'solicitudes.view',
                'solicitudes.approve',
            ])->pluck('id')
        );

        $compras->permissions()->sync(
            Permission::whereIn('name', [
                'view_products','view_reports',

                 // SOLICITUDES
                'solicitudes.view',
            ])->pluck('id')
        );

        $auditor->permissions()->sync(
            Permission::whereIn('name', [
                'view_products','view_entries','view_exits','view_reports','export_reports',
            
                // SOLICITUDES
                'solicitudes.view',
            ])->pluck('id')
        );
    }
}

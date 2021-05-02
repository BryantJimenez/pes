<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permiso para Acceder al Panel Administrativo
        Permission::create(['name' => 'dashboard']);

        // Permisos de Usuarios
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.active']);
        Permission::create(['name' => 'users.deactive']);

        // Permisos de Códigos Postales
        Permission::create(['name' => 'zip.index']);
        Permission::create(['name' => 'zip.create']);
        Permission::create(['name' => 'zip.edit']);
        Permission::create(['name' => 'zip.delete']);
        Permission::create(['name' => 'zip.active']);
        Permission::create(['name' => 'zip.deactive']);

        // Permisos de Colonias
        Permission::create(['name' => 'colonies.index']);
        Permission::create(['name' => 'colonies.create']);
        Permission::create(['name' => 'colonies.edit']);
        Permission::create(['name' => 'colonies.delete']);
        Permission::create(['name' => 'colonies.active']);
        Permission::create(['name' => 'colonies.deactive']);

        // Permisos de Secciones
    	Permission::create(['name' => 'sections.index']);
    	Permission::create(['name' => 'sections.create']);
    	Permission::create(['name' => 'sections.edit']);
    	Permission::create(['name' => 'sections.delete']);
        Permission::create(['name' => 'sections.active']);
        Permission::create(['name' => 'sections.deactive']);

        // Permisos de Informes
        Permission::create(['name' => 'reports.index']);

    	$superadmin=Role::create(['name' => 'Super Admin']);
        $superadmin->givePermissionTo(Permission::all());
        
        $admin=Role::create(['name' => 'Administrador']);
    	$admin->givePermissionTo(Permission::all());

        $analyst=Role::create(['name' => 'Analista']);
        $analyst->givePermissionTo(Permission::all());

        $coordinator=Role::create(['name' => 'Coordinador de Ruta']);
        $coordinator->givePermissionTo(['dashboard', 'users.index', 'users.create', 'users.show', 'users.edit', 'users.delete', 'users.active', 'users.deactive']);

        $sectional=Role::create(['name' => 'Seccional']);
        $sectional->givePermissionTo(['dashboard', 'users.index', 'users.create', 'users.show', 'users.edit', 'users.delete', 'users.active', 'users.deactive']);

        $leader=Role::create(['name' => 'Líder']);
        $leader->givePermissionTo(['dashboard', 'users.index', 'users.create', 'users.show', 'users.edit']);

        $promoted=Role::create(['name' => 'Promovido']);

    	$user=User::find(1);
    	$user->assignRole('Super Admin');
    }
}

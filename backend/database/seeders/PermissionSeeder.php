<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === Permisos base (puedes extenderlos luego: surveys, questions, etc.) ===
        $permissions = [
            // Usuarios (staff + students como usuarios)
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            // Staff
            'staff.view',
            'staff.create',
            'staff.update',
            'staff.delete',

            // Students
            'students.view',
            'students.create',
            'students.update',
            'students.delete',

            // Catálogos académicos
            'institutes.manage',
            'careers.manage',
            'groups.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $professor  = Role::firstOrCreate(['name' => 'professor']);
        $student    = Role::firstOrCreate(['name' => 'student']);

        // SUPERADMIN: todo
        $superadmin->syncPermissions(Permission::all());

        // ADMIN (de instituto): todo CRUD de su instituto
        $admin->syncPermissions([
            'users.view', 'users.create', 'users.update', 'users.delete',
            'staff.view', 'staff.create', 'staff.update', 'staff.delete',
            'students.view', 'students.create', 'students.update', 'students.delete',
            'institutes.manage', 'careers.manage', 'groups.manage',
        ]);

        // PROFESSOR: limitado (gestiona students de su instituto, ve staff)
        $professor->syncPermissions([
            'students.view', 'students.create', 'students.update',
            'staff.view',
            'groups.manage', // (opcional: si quieres que cree y asigne grupos)
        ]);

        // STUDENT: básico (ver/actualizar su perfil propio; lo afinaremos con Policies)
        $student->syncPermissions([
            'students.view', 'students.update',
        ]);
        
    }
}

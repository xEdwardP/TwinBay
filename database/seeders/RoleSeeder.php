<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'SUPER ADMIN']);

        Role::create(['name' => 'ADMINISTRADOR']);
        Role::create(['name' => 'OPERADOR']);

        $permissions = [
            'settings' => ['index', 'store'],
            'users' => [
                'index',
                'store',
                'create',
                'edit',
                'update',
                'show',
                'destroy',
                'restore',
                'profile',
                'update_profile',
                'change_password'
            ],
            'roles' => ['index', 'store', 'edit', 'update', 'destroy', 'show_permissions', 'assign_permissions'],
            'spaces' => ['index', 'create', 'store', 'update', 'destroy'],
            'rates' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
            'customers' => [
                'index',
                'create',
                'store',
                'edit',
                'update',
                'show',
                'destroy',
                'restore'
            ],
            'vehicles' => ['index', 'store', 'update', 'destroy'],
            'tickets' => [
                'index',
                'search_vehicle',
                'store',
                'update',
                'complete_invoice',
                'destroy',
                'print_ticket',
                'calcAmount'
            ],
            'invoices' => ['index','print'],
            'analytics' => ['index'],
            'reports' => ['index', 'weekly_report', 'monthly_report', 'daily_report'],
        ];

        foreach ($permissions as $group => $actions) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$group}.{$action}"])->syncRoles($superAdmin);
            }
        }
    }
}

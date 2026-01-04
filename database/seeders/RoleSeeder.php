<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Customers
            'view customers',
            'create customers',
            'edit customers',
            'delete customers',

            // Services
            'view services',
            'create services',
            'edit services',
            'delete services',

            // Orders
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',

            // Payments
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',

            // Reports
            'view reports',

            // Invoices
            'view invoices',
            'create invoices',
            'send invoices',

            // Users & Roles (Admin only)
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Settings
            'view settings',
            'edit settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Admin - All permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Manager - Can manage most things but not users/roles
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view customers',
            'create customers',
            'edit customers',
            'view services',
            'create services',
            'edit services',
            'view orders',
            'create orders',
            'edit orders',
            'view payments',
            'create payments',
            'edit payments',
            'view reports',
            'view invoices',
            'create invoices',
            'send invoices',
        ]);

        // Cashier - Limited to transactions
        $cashierRole = Role::create(['name' => 'cashier']);
        $cashierRole->givePermissionTo([
            'view customers',
            'create customers',
            'view services',
            'view orders',
            'create orders',
            'edit orders',
            'view payments',
            'create payments',
            'view invoices',
            'create invoices',
        ]);

        // Staff - View and create orders, limited edit
        $staffRole = Role::create(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view customers',
            'view services',
            'view orders',
            'create orders',
            'edit orders',
            'view payments',
            'view invoices',
        ]);

        // Create default admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@laundry.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Create sample manager
        $manager = User::updateOrCreate(
            ['email' => 'manager@laundry.com'],
            [
                'name' => 'Manager',
                'password' => Hash::make('manager123'),
                'email_verified_at' => now(),
            ]
        );
        $manager->assignRole('manager');

        // Create sample cashier
        $cashier = User::updateOrCreate(
            ['email' => 'cashier@laundry.com'],
            [
                'name' => 'Cashier',
                'password' => Hash::make('cashier123'),
                'email_verified_at' => now(),
            ]
        );
        $cashier->assignRole('cashier');

        // Create sample staff
        $staff = User::updateOrCreate(
            ['email' => 'staff@laundry.com'],
            [
                'name' => 'Staff',
                'password' => Hash::make('staff123'),
                'email_verified_at' => now(),
            ]
        );
        $staff->assignRole('staff');

        $this->command->info('Roles and permissions seeded successfully!');
        $this->command->info('Default users created:');
        $this->command->info('- admin@laundry.com / admin123 (Admin)');
        $this->command->info('- manager@laundry.com / manager123 (Manager)');
        $this->command->info('- cashier@laundry.com / cashier123 (Cashier)');
        $this->command->info('- staff@laundry.com / staff123 (Staff)');
    }
}


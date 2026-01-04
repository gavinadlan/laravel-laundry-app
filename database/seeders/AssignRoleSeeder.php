<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create admin user
        $user = User::where('email', 'admin@laundry.com')->first();

        if ($user) {
            // Get admin role
            $adminRole = Role::where('name', 'admin')->first();

            if ($adminRole && !$user->hasRole('admin')) {
                $user->assignRole($adminRole);
                $this->command->info("Role 'admin' assigned to {$user->email}");
            } else {
                $this->command->info("User {$user->email} already has admin role or role not found");
            }
        } else {
            $this->command->error("User with email admin@laundry.com not found");
        }
    }
}


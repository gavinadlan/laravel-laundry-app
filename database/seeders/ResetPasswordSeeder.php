<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResetPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@laundry.com')->first();

        if ($user) {
            $user->password = Hash::make('password');
            $user->save();
            $this->command->info("Password reset successfully for {$user->email}");
            $this->command->info("Email: {$user->email}");
            $this->command->info("Password: password");
        } else {
            $this->command->error("User with email admin@laundry.com not found");
        }
    }
}


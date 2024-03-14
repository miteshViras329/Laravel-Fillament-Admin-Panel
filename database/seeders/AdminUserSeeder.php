<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $checkUser = User::where('email', config('app.admin_user_email'))->first();
        if (!$checkUser) {
            User::create([
                'name' => 'Admin',
                'email' => config('app.admin_user_email'),
                'email_verified_at' => now(),
                'password' => 'admin@123',
                'is_admin' => true,
            ]);
        }
    }
}

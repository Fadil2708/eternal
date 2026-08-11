<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@eternal.skb-prime.web.id'],
            ['password' => bcrypt('password'), 'role' => 'admin', 'email_verified_at' => now()],
        );

    }
}

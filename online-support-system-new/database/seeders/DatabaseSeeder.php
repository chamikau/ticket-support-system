<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Support Agent',
            'email' => 'agent@mail.com',
            'password' => bcrypt('password'),
        ]);
    }
}

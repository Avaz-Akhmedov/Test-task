<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'first_name' => 'test',
            'last_name' => 'testov',
            'email' => 'test@gmail.com',
            'password' => 111222,
            'phone' => 9054422112
        ]);
    }
}

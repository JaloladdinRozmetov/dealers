<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => "User ",
            'email' => "user@example.com",
            'password' => Hash::make('password'), // Default password
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        echo "User: " . $user->email . " | Token: " . $token . "\n";
    }
}

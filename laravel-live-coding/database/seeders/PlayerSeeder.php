<?php

namespace Database\Seeders;

// PlayerSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Player;

class PlayerSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Player::create([
                'username' => 'test' . ($i + 1),
                'first_name' => 'test',
                'last_name' => 'person',
                'gender' => 'male',
                'lang' => 'en',
                'email' => 'testPlayer' . ($i + 1) . '@gmail.com',
                'rank_id' => 3,
                'password' => '$2a$12$Xti5fVgbtwVQ8C8EtNPa9O..nilnD.sdfsdfsdf.QbzvcTd92krhO',
                'balance' => '0.0000',
                'is_blocked' => '0',
                'created_at' => '2024-02-12 12:38:20',
                'updated_at' => '2024-02-12 12:38:21',
            ]);
        }
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@test.com',
            'password' => '$2a$12$Xti5fVgbtwVQ8C8EtNPa9O..nilnD.sdfsdfsdf.QbzvcTd92krhO',
            'created_at' => '2023-11-14 09:30:08',
            'updated_at' => '2024-01-15 12:35:21'
        ]);
    }
}

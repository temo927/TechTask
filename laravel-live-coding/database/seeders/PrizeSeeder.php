<?php

namespace Database\Seeders;

use App\Models\Prize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prizes = [
            [
                'name' => 'Lottery 1',
                'type' => 'lottery',
                'created_at' => '2024-03-06 09:13:59',
                'updated_at' => '2024-03-11 13:09:16'
            ],
            [
                'name' => 'BNB',
                'type' => 'custom_prize',
                'created_at' => '2024-03-06 09:13:59',
                'updated_at' => '2024-03-11 13:09:16'
            ],
            [
                'name' => 'BNB',
                'type' => 'custom_prize',
                'created_at' => '2024-03-06 09:13:59',
                'updated_at' => '2024-03-11 13:09:16'
            ]
        ];

        foreach ($prizes as $prize) {
            Prize::create($prize);
        }

    }
}

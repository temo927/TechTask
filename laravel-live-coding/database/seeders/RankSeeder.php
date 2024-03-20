<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            ['name' => 'Newcomer'],
            ['name' => 'Bronze'],
            ['name' => 'Silver'],
            ['name' => 'Gold'],
            ['name' => 'Platinum'],
            ['name' => 'Diamond'],
            ['name' => 'Master'],
            ['name' => 'Grandmaster'],
            ['name' => 'Champion'],
            ['name' => 'Legend'],
            ['name' => 'Godlike']
        ];

        foreach ($ranks as $rank) {
            Rank::create($rank);
        }
    }
}

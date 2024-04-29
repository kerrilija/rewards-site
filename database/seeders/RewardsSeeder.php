<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RewardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('data/rewards_model.csv');

        // Each line of the file becomes an array element
        $data = array_map('str_getcsv', file($csvFile));

        foreach ($data as $row) {
            DB::table('rewards')->insert([
                'type' => trim($row[0]),
                'level' => trim($row[1]),
                'reward' => trim($row[2]),
                'description' => trim($row[3]),
                'general_description' => trim($row[4]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}

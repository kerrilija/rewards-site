<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CyclesSeeder extends Seeder
{
    public function run()
    {
        // Process the legacy contributions file
        $this->processFile(base_path("database/data/legacy_contributions.csv"));
        
        // Process the current contributions file
        $this->processFile(base_path("database/data/contributions.csv"));
    }

    private function processFile($filePath)
    {
        $csvFile = fopen($filePath, "r");
        if (!$csvFile) {
            echo "Failed to open $filePath\n";
            return;
        }

        while (($row = fgetcsv($csvFile)) !== FALSE) {
            $row = array_map(function ($value) {
                return $value === 'NULL' ? null : $value;
            }, $row);

            $startDate = $row[1];
            $endDate = $row[2];

            $cycleExists = DB::table('cycles')
                             ->where('start', $startDate)
                             ->where('end', $endDate)
                             ->exists();

            if (!$cycleExists) {
                DB::table('cycles')->insert([
                    'start' => $startDate,
                    'end' => $endDate
                ]);
                echo "Inserted from $filePath: Start Date - " . ($startDate ?: "null") . ", End Date - " . ($endDate ?: "null") . "\n";
            } else {
                echo "Skipped from $filePath: Start Date - " . ($startDate ?: "null") . ", End Date - " . ($endDate ?: "null") . " (already exists)\n";
            }
        }

        fclose($csvFile);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContributorsSeeder extends Seeder
{
    public function run()
    {
        $this->processContributors(base_path("database/data/legacy_contributions.csv"));
        
        $this->processContributors(base_path("database/data/contributions.csv"));
    }

    private function processContributors($filePath)
    {
        $csvFile = fopen($filePath, "r");
        if (!$csvFile) {
            echo "Failed to open $filePath\n";
            return;
        }

        while (($row = fgetcsv($csvFile)) !== FALSE) {
            $name = trim($row[0]);  // Get the name from the first column and trim any whitespace

            $contributorExists = DB::table('contributors')
                                   ->where('name', $name)
                                   ->exists();

            if (!$contributorExists && !empty($name)) {
                DB::table('contributors')->insert([
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                echo "Inserted Contributor: $name\n";
            } else {
                echo "Skipped Contributor: $name (already exists or name is empty)\n";
            }
        }

        fclose($csvFile);
    }
}

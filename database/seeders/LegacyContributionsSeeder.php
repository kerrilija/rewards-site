<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyContributionsSeeder extends Seeder
{
    public function run()
    {
        $this->processLegacyContributions(base_path("database/data/legacy_contributions.csv"));
    }

    private function processLegacyContributions($filePath)
    {
        $csvFile = fopen($filePath, "r");
        if (!$csvFile) {
            echo "Failed to open $filePath\n";
            return;
        }

        $rowNumber = 0;
        while (($row = fgetcsv($csvFile)) !== FALSE) {
            $rowNumber++;

            $contributorName = $row[0];
            $startDate = $row[1];
            $platform = $this->nullify($row[3]);
            $url = $this->nullify($row[4]);
            $type = $this->nullify($row[5]);
            $level = $this->nullify($row[6]);
            $percentage = $this->nullify($row[7]);
            $reward = $this->nullify($row[8]);
            $comment = $this->nullify($row[9]);

            $contributor = DB::table('contributors')->where('name', $contributorName)->first();
            $cycle = DB::table('cycles')->where('start', $startDate)->first();

            if (!$contributor || !$cycle) {
                echo "Error: Missing contributor or cycle for $contributorName with start date $startDate at row $rowNumber\n";
                continue;
            }

            try {
                DB::table('legacy_contributions')->insert([
                    'contributor_id' => $contributor->id,
                    'cycle_id' => $cycle->id,
                    'platform' => $platform,
                    'url' => $url,
                    'type' => $type,
                    'level' => $level,
                    'percentage' => $percentage,
                    'reward' => $reward,
                    'comment' => $comment,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                echo "Inserted Legacy Contribution for $contributorName on $startDate at row $rowNumber\n";
            } catch (\Exception $e) {
                echo "Failed to insert legacy contribution for $contributorName on $startDate at row $rowNumber: " . $e->getMessage() . "\n";
            }
        }

        fclose($csvFile);
    }

    private function nullify($value)
    {
        return $value === 'NULL' ? null : $value;
    }
}

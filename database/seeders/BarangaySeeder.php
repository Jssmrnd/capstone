<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlFilePath = __DIR__ . '/refbrgy.sql';
        $sqlContent = file_get_contents($sqlFilePath);
        $batchSize = 5000; // Adjust as needed

        // Split the SQL content into individual queries and prepend 'INSERT INTO'
        $queries = preg_split("/\)\,\s*\(/", $sqlContent);
        $queries = array_map(function ($query) {
            return "INSERT INTO `refbrgy` (`id`, `brgyCode`, `brgyDesc`, `regCode`, `provCode`, `citymunCode`) VALUES (" . $query . ")";
        }, $queries);

        // Process and execute queries in batches
        $batch = [];
        foreach ($queries as $query) {
            $batch[] = $query;

            if (count($batch) === $batchSize) {
                $batchQuery = implode(";\n", $batch);
                DB::unprepared($batchQuery);
                $batch = [];
            }
        }

        // Insert any remaining queries (less than the batch size)
        if (!empty($batch)) {
            $batchQuery = implode(";\n", $batch);
            DB::unprepared($batchQuery);
        }
    }
}

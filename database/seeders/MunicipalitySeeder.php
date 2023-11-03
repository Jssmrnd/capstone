<?php

namespace Database\Seeders;

use App\Models\RefMunicipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set the path of your .sql file
        DB::unprepared(file_get_contents(__DIR__ . '/ref_municipalities.sql'));
    }
}

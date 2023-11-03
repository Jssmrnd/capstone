<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::query()->create([
            "id" => 1,
            "brgyCode" => "041034018",                  //Sabang
            "regCode" => "04",                          //CALABARZON
            "provCode" => "0410",                       //Batangas
            "citymunCode" => "041034",                  //Tuy
            "street_name" => "Sitio Casuan No. 60",
            "full_address" => "REGION IV-A (CALABARZON), BATANGAS, TUY, Sitio Casuan No. 60",
        ]);
    }
}

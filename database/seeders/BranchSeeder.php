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
        $this->createBranch();
    }

    public function createBranch(): void
    {
        //Nasugbu
        Branch::query()->create([
            "id" => 1,
            "brgyCode" => "041019007",                  //Brgy 2 Poblacion
            "regCode" => "04",                          //CALABARZON
            "provCode" => "0410",                       //Batangas
            "citymunCode" => "041019",                  //Nasugbu
            "street_name" => "JP Laurel",
            "full_address" => "REGION IV-A (CALABARZON), BATANGAS, NASUGBU, JP Laurel",
        ]);
        //Balayan
        Branch::query()->create([
            "id" => 2,
            "brgyCode" => "041003018",                  //Calzada
            "regCode" => "04",                          //CALABARZON
            "provCode" => "0410",                       //Batangas
            "citymunCode" => "041003",                  //Balayan
            "street_name" => "Calzada",
            "full_address" => "REGION IV-A (CALABARZON), BATANGAS, BALAYAN, Paz Street",
        ]);

    }

}

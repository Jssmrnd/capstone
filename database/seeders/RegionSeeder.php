<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RefRegion;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRegion();
    }

    private function createRegion(): void
    {

        RefRegion::create( [
            'id'=>1,
            'psgcCode'=>'010000000',
            'regDesc'=>'REGION I (ILOCOS REGION)',
            'regCode'=>'01'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>2,
            'psgcCode'=>'020000000',
            'regDesc'=>'REGION II (CAGAYAN VALLEY)',
            'regCode'=>'02'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>3,
            'psgcCode'=>'030000000',
            'regDesc'=>'REGION III (CENTRAL LUZON)',
            'regCode'=>'03'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>4,
            'psgcCode'=>'040000000',
            'regDesc'=>'REGION IV-A (CALABARZON)',
            'regCode'=>'04'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>5,
            'psgcCode'=>'170000000',
            'regDesc'=>'REGION IV-B (MIMAROPA)',
            'regCode'=>'17'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>6,
            'psgcCode'=>'050000000',
            'regDesc'=>'REGION V (BICOL REGION)',
            'regCode'=>'05'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>7,
            'psgcCode'=>'060000000',
            'regDesc'=>'REGION VI (WESTERN VISAYAS)',
            'regCode'=>'06'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>8,
            'psgcCode'=>'070000000',
            'regDesc'=>'REGION VII (CENTRAL VISAYAS)',
            'regCode'=>'07'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>9,
            'psgcCode'=>'080000000',
            'regDesc'=>'REGION VIII (EASTERN VISAYAS)',
            'regCode'=>'08'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>10,
            'psgcCode'=>'090000000',
            'regDesc'=>'REGION IX (ZAMBOANGA PENINSULA)',
            'regCode'=>'09'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>11,
            'psgcCode'=>'100000000',
            'regDesc'=>'REGION X (NORTHERN MINDANAO)',
            'regCode'=>'10'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>12,
            'psgcCode'=>'110000000',
            'regDesc'=>'REGION XI (DAVAO REGION)',
            'regCode'=>'11'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>13,
            'psgcCode'=>'120000000',
            'regDesc'=>'REGION XII (SOCCSKSARGEN)',
            'regCode'=>'12'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>14,
            'psgcCode'=>'130000000',
            'regDesc'=>'NATIONAL CAPITAL REGION (NCR)',
            'regCode'=>'13'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>15,
            'psgcCode'=>'140000000',
            'regDesc'=>'CORDILLERA ADMINISTRATIVE REGION (CAR)',
            'regCode'=>'14'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>16,
            'psgcCode'=>'150000000',
            'regDesc'=>'AUTONOMOUS REGION IN MUSLIM MINDANAO (ARMM)',
            'regCode'=>'15'
            ] );
            
            
                        
            RefRegion::create( [
            'id'=>17,
            'psgcCode'=>'160000000',
            'regDesc'=>'REGION XIII (Caraga)',
            'regCode'=>'16'
            ] );

    }

}

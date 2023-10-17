<?php

namespace App\Filament\Resources\BranchResource\Pages;

use App\Filament\Resources\BranchResource;
use App\Models\RefMunicipality;
use App\Models\RefProvince;
use App\Models\RefRegion;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // set mutations.
        $region = RefRegion::query()
                ->where('regCode', $data['regCode'])
                        ->first()
                                ->regDesc;
        $province = RefProvince::query()
                ->where('provCode', $data['provCode'])
                        ->first()
                                ->provDesc;
        $municipilaty = RefMunicipality::query()
                ->where('citymunCode', $data['citymunCode'])
                        ->first()
                                ->citymunDesc;
        $data['full_address'] = $region.", ".$province.", ".$municipilaty.", ".$data['street_name'];
        return $data;
    }
}

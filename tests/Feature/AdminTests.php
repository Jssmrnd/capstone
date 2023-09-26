<?php

use App\Filament\Resources\PermissionsResource;
use App\Filament\Resources\RolesResource;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Z3d0X\FilamentFabricator\Resources\PageResource;
use function Pest\Livewire\livewire;

it('can login', function () {
    $response = $this->get('/admin');

    $response->assertStatus(200);
});


it('can access permissions Module', function () {
    $this->get(PermissionsResource::getUrl('index'))->assertSuccessful();
});

it('can access Roles Module', function () {
    $this->get(RolesResource::getUrl('index'))->assertSuccessful();
});

it('can access Page Module', function () {
    $this->get(PageResource::getUrl('index'))->assertSuccessful();
});

it('can access Customer Application Module', function () {
    $this->get(PageResource::getUrl('index'))->assertSuccessful();
});


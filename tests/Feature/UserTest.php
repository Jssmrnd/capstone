<?php

use App\Filament\Resources\UserResource;
use App\Models\User;
use Database\Factories\RoleFactory;
use Spatie\Permission\Models\Role;

use function Pest\Livewire\livewire;


test('access admin panel', function () {
    $response = $this->get('/admin');
    $response->assertStatus(200);
});


test('render create user page', function () {
    $this->get(UserResource::getUrl('create'))
            ->assertSuccessful();
});


test('validate input null', function () {
    // $newData = User::factory()->make();
 
    livewire(UserResource\Pages\CreateUser::class)
        ->fillForm([
            'name' => null,
            'is_admin' => null,
            'branch_id' => null,
            'gender' => null,
            'birthday' => null,
            'contact_number' => null,
            'email' => null,
            'password' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
            'is_admin' => 'required',
            'branch_id' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
});


test('validates input ', function () {
    $newData = User::factory()->make();
    livewire(UserResource\Pages\CreateUser::class)
        ->fillForm([
            'name' => $newData->name,
            'is_admin' => $newData->is_admin,
            'branch_id' => $newData->branch_id,
            'gender' => $newData->gender,
            'roles' => 2,
            'birthday' => $newData->birthday,
            'contact_number' => $newData->contact_number,
            'email' => $newData->email,
            'password' => $newData->password,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
        $this->assertDatabaseHas(User::class, [
            'name' => $newData->name,
            'is_admin' => $newData->is_admin,
            'branch_id' => $newData->branch_id,
            'gender' => $newData->gender,
            'birthday' => $newData->birthday,
            'contact_number' => $newData->contact_number,
            'email' => $newData->email,
            'password' => $newData->password,
        ]);

});

test('can access User Module', function () {
    $this->get(UserResource::getUrl('index'))->assertSuccessful();
});

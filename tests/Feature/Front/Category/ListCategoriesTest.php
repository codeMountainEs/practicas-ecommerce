<?php

use App\Models\Category;

use Illuminate\Foundation\Testing\RefreshDatabase; 

uses(RefreshDatabase::class);


use App\Filament\Resources\RoleResource;
use App\Filament\Resources\RoleResource\Pages\CreateRole;
use App\Models\Role as Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Filament\Actions\CreateAction;
use Livewire\Livewire;

//use function Pest\Livewire\livewire;

it('can create roles', function () {

    $this->seed(RoleSeeder::class); 

    $this->actingAs(User::factory()->create());

    // Visita la página de listado de roles
    $this->get(RoleResource::getUrl('index'));

   


    
});


it('can list Roles', function () {
    $roles = Role::factory()->count(10)->create();
 //dd($roles[0]);
    Livewire::test(RoleResource\Pages\ListRoles::class)
        ->assertCanSeeTableRecords($roles)
       
        ->assertSeeText($roles[0]->namessss)
        ;
});

it('can create Role', function () {

    $role= Role::factory()->make();

    Livewire::test(CreateRole::class)
    ->fillForm(['name' => $role->name, 'slugs' => $role->slug])
    ->call('create')
    ->assertHasNoFormErrors()
    ;

});


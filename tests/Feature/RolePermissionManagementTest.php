<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('it returns a role and its permission ids for editing', function () {
    $editPermission = Permission::create(['name' => 'roles.edit']);
    $assignedPermission = Permission::create(['name' => 'users.create']);
    $managerRole = Role::create(['name' => 'Manager']);
    $managerRole->givePermissionTo($editPermission);
    $manager = User::factory()->create();
    $manager->assignRole($managerRole);
    $role = Role::create(['name' => 'Editor']);
    $role->givePermissionTo($assignedPermission);

    $this->actingAs($manager)
        ->getJson(route('roles.edit', $role))
        ->assertOk()
        ->assertJsonPath('status', 'success')
        ->assertJsonPath('data.id', $role->id)
        ->assertJsonPath('data.name', 'Editor')
        ->assertJsonPath('data.permissions.0', $assignedPermission->id);
});

test('it deletes a role when the user has permission', function () {
    $destroyPermission = Permission::create(['name' => 'roles.destroy']);
    $managerRole = Role::create(['name' => 'Manager']);
    $managerRole->givePermissionTo($destroyPermission);
    $manager = User::factory()->create();
    $manager->assignRole($managerRole);
    $role = Role::create(['name' => 'Editor']);

    $this->actingAs($manager)
        ->deleteJson(route('roles.delete', $role))
        ->assertOk()
        ->assertJsonPath('status', 'success');

    $this->assertDatabaseMissing('roles', ['id' => $role->id]);
});

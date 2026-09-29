<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

function userPayload(Role $role, array $overrides = []): array
{
    return array_merge([
        'role_id' => $role->id,
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'mobile_code' => '+91',
        'mobile_number' => '9876543210',
    ], $overrides);
}

function userAdmin(array $permissions = ['users.create', 'users.edit', 'users.destroy']): User
{
    $manager = Role::create(['name' => 'Manager']);
    $manager->syncPermissions(collect($permissions)->map(fn (string $name) => Permission::create(['name' => $name])));
    $user = User::factory()->create();
    $user->assignRole($manager);

    return $user;
}

test('it creates a user with a role', function () {
    $admin = userAdmin();
    $role = Role::create(['name' => 'User']);

    $this->actingAs($admin)
        ->postJson(route('users.store'), userPayload($role))
        ->assertCreated()
        ->assertJsonPath('status', 'success');

    $this->assertDatabaseHas('users', [
        'email' => 'jane@example.com',
        'mobile_code' => '+91',
        'mobile_number' => '9876543210',
    ]);
});

test('it returns a validation error for a duplicate mobile number', function () {
    $admin = userAdmin();
    $role = Role::create(['name' => 'User']);
    User::factory()->create(['mobile_code' => '+91', 'mobile_number' => '9876543210']);

    $this->actingAs($admin)
        ->postJson(route('users.store'), userPayload($role))
        ->assertUnprocessable()
        ->assertJsonValidationErrors('mobile_number');
});

test('it returns user data for editing and updates the user', function () {
    $admin = userAdmin();
    $role = Role::create(['name' => 'User']);
    $user = User::factory()->create([
        'mobile_code' => '+91',
        'mobile_number' => '9876543210',
    ]);
    $user->assignRole($role);

    $this->actingAs($admin)
        ->getJson(route('users.edit', $user))
        ->assertOk()
        ->assertJsonPath('data.id', $user->id)
        ->assertJsonPath('data.role_id', $role->id);

    $this->actingAs($admin)
        ->postJson(route('users.update', $user), userPayload($role, [
            'name' => 'Updated User',
            'email' => $user->email,
        ]))
        ->assertOk()
        ->assertJsonPath('status', 'success');

    $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated User']);
});

test('it deletes a user', function () {
    $admin = userAdmin();
    $user = User::factory()->create();

    $this->actingAs($admin)
        ->deleteJson(route('users.delete', $user))
        ->assertOk()
        ->assertJsonPath('status', 'success');

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

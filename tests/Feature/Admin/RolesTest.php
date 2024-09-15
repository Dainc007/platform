<?php

use App\Filament\Resources\RoleResource;
use App\Filament\Resources\RoleResource\Pages\CreateRole;
use App\Filament\Resources\RoleResource\Pages\EditRole;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->role = Role::create([
        'name' => 'head admin',
        'guard_name' => 'web'
    ]);

    $this->user->assignRole($this->role->name);
});

describe('index page', function () {
    test('can render index page', function () {
        $url = RoleResource::getUrl('index');

        $unauthorized = User::factory()->create();

        $this->get($url)->assertRedirect();
        $this->actingAs($this->user)->get($url)->assertSuccessful();
        $this->actingAs($unauthorized)->get($url)->assertForbidden();
    });

    test('can list posts', function () {
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'moderator',
            'guard_name' => 'web'
        ]);

        livewire(RoleResource\Pages\ListRoles::class)
            ->assertCanSeeTableRecords(Role::get())
            ->assertCountTableRecords(3)
            ->assertCanRenderTableColumn('name');
    });
});

describe('create page', function () {
    test('can render create page', function () {
        $url = RoleResource::getUrl('create');

        $unauthorized = User::factory()->create();

        $this->get($url)->assertRedirect();
        $this->actingAs($this->user)->get($url)->assertSuccessful();
        $this->actingAs($unauthorized)->get($url)->assertForbidden();
    });

    test('can create role with permissions and assign to user', function () {
        $permission = Permission::create([
            'name' => 'can-create-article'
        ]);

        $user = User::factory()->create();

        $roleName = fake()->sentence();

        livewire(CreateRole::class)
            ->fillForm([
                'name' => $roleName,
                'permissions' => [$permission->id],
                'users' => [$user->id]
            ])
            ->call('create')
            ->assertHasNoErrors();

        $createdRole = Role::query()
            ->where('name', $roleName)
            ->firstOrFail(['id']);

        $this->assertDatabaseHas(Role::class, [
            'name' => $roleName,
            'guard_name' => config('auth.defaults.guard')
        ]);
        $this->assertDatabaseHas(
            config('permission.table_names.role_has_permissions'),
            [
                'permission_id' => $permission->id,
                'role_id' => $createdRole->id
            ]
        );
        $this->assertDatabaseHas(
            config('permission.table_names.model_has_roles'),
            [
                'role_id' => $createdRole->id,
                'model_type' => 'App\Models\User',
                'model_id' => $user->id
            ]
        );
    });

    test('can create role with permissions and do not assign to user', function () {
        $permission = Permission::create([
            'name' => 'can-create-article'
        ]);

        $roleName = fake()->sentence();

        livewire(CreateRole::class)
            ->fillForm([
                'name' => $roleName,
                'permissions' => [$permission->id],
            ])
            ->call('create')
            ->assertHasNoErrors();

        $createdRole = Role::query()
            ->where('name', $roleName)
            ->firstOrFail(['id']);

        $this->assertDatabaseHas(Role::class, [
            'name' => $roleName,
            'guard_name' => config('auth.defaults.guard')
        ]);
        $this->assertDatabaseHas(
            config('permission.table_names.role_has_permissions'),
            [
                'permission_id' => $permission->id,
                'role_id' => $createdRole->id
            ]
        );
    });

    test('can create role without permissions', function () {
        $roleName = fake()->sentence();

        livewire(CreateRole::class)
            ->fillForm([
                'name' => $roleName,
            ])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas(Role::class, [
            'name' => $roleName,
            'guard_name' => config('auth.defaults.guard')
        ]);
    });

    test('cannot create role with already occupied name', function () {
        $roleName = fake()->sentence();

        livewire(CreateRole::class)
            ->fillForm([
                'name' => $this->role->name,
            ])
            ->call('create')
            ->assertHasErrors('data.name');

        $this->assertDatabaseMissing(Role::class, [
            'name' => $roleName,
            'guard_name' => config('auth.defaults.guard')
        ]);
    });
});

describe('edit page', function () {
    test('can render edit page', function () {
        $unauthorized = User::factory()->create();

        $url = RoleResource::getUrl('edit', ['record' => $this->role]);

        $this->get($url)->assertRedirect();
        $this->actingAs($this->user)->get($url)->assertSuccessful();
        $this->actingAs($unauthorized)->get($url)->assertForbidden();
    });

    test('can edit role name', function () {
        livewire(EditRole::class, ['record' => $this->role->id])
            ->fillForm([
                'name' => $this->role->name . ' edited',
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->role->refresh();

        $this->assertSame($this->role->name, 'head admin edited');
    });

    test('can change permissions', function () {
        $permission = Permission::create([
            'name' => 'can-create-article'
        ]);

        $permission2 = Permission::create([
            'name' => 'can-create-blog'
        ]);

        $permission->assignRole($this->role);

        $this->assertDatabaseHas(
            config('permission.table_names.role_has_permissions'),
            [
                'permission_id' => $permission->id,
                'role_id' => $this->role->id
            ]
        );

        $this->assertDatabaseMissing(
            config('permission.table_names.role_has_permissions'),
            [
                'permission_id' => $permission2->id,
                'role_id' => $this->role->id
            ]
        );

        livewire(EditRole::class, ['record' => $this->role->id])
            ->fillForm([
                'permissions' => [$permission2->id]
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing(
            config('permission.table_names.role_has_permissions'),
            [
                'permission_id' => $permission->id,
                'role_id' => $this->role->id
            ]
        );

        $this->assertDatabaseHas(
            config('permission.table_names.role_has_permissions'),
            [
                'permission_id' => $permission2->id,
                'role_id' => $this->role->id
            ]
        );
    });

    test('can change users', function () {
        $user = User::factory()->create();

        $this->assertDatabaseHas(
            config('permission.table_names.model_has_roles'),
            [
                'role_id' => $this->role->id,
                'model_type' => 'App\Models\User',
                'model_id' => $this->user->id
            ]
        );

        $this->assertDatabaseMissing(
            config('permission.table_names.model_has_roles'),
            [
                'role_id' => $this->role->id,
                'model_type' => 'App\Models\User',
                'model_id' => $user->id
            ]
        );

        livewire(EditRole::class, ['record' => $this->role->id])
            ->fillForm([
                'users' => [$user->id]
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseMissing(
            config('permission.table_names.model_has_roles'),
            [
                'role_id' => $this->role->id,
                'model_type' => 'App\Models\User',
                'model_id' => $this->user->id
            ]
        );

        $this->assertDatabaseHas(
            config('permission.table_names.model_has_roles'),
            [
                'role_id' => $this->role->id,
                'model_type' => 'App\Models\User',
                'model_id' => $user->id
            ]
        );
    });
});

describe('delete role', function () {
    test('can delete role', function () {
        livewire(EditRole::class, [
            'record' => $this->role->id
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($this->role);
    });
});

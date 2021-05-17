<?php

namespace Tests\Feature\Admin\NavigationMenu;

use App\Http\Livewire\UserPermissions;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class CreateUserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_new_user_permissions()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(UserPermissions::class)
            ->set('role', 'foo')
            ->set('routeName', 'mock')
            ->call('create');

        $this->assertTrue(UserPermission::whereRole('foo')->exists());
    }

    public function test_create_user_permission_role_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(UserPermissions::class)
            ->set('role', '')
            ->set('routeName', 'mock')
            ->call('create')
            ->assertHasErrors('role');
    }

    public function test_create_user_permission_route_name_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(UserPermissions::class)
            ->set('role', 'editor')
            ->set('routeName', '')
            ->call('create')
            ->assertHasErrors('routeName');
    }
}

<?php

namespace Tests\Feature\Admin\NavigationMenu;

use App\Http\Livewire\UserPermissions;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class UpdateUserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_user_permission()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $userPermisson = UserPermission::create(['role' => 'user', 'routeName' => 'mock']);

        Livewire::test(UserPermissions::class)
            ->set('modelId', $userPermisson->id)
            ->set('role', 'editor')
            ->set('routeName', 'mock')
            ->call('update');

        $this->assertTrue(UserPermission::whereRole('editor')->exists());
    }

    public function test_update_user_permission_role_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $userPermisson = UserPermission::create(['role' => 'user', 'routeName' => 'mock']);

        Livewire::test(UserPermissions::class)
            ->set('modelId', $userPermisson->id)
            ->set('role', '')
            ->set('routeName', 'mock')
            ->call('update')
            ->assertHasErrors('role');
    }

    public function test_update_user_permission_route_name_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        
        $userPermisson = UserPermission::create(['role' => 'user', 'routeName' => 'mock']);

        Livewire::test(UserPermissions::class)
            ->set('modelId', $userPermisson->id)
            ->set('role', 'editor')
            ->set('routeName', '')
            ->call('update')
            ->assertHasErrors('routeName');
    }
}

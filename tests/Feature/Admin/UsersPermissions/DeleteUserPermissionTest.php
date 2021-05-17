<?php

namespace Tests\Feature\Admin\NavigationMenu;

use App\Http\Livewire\UserPermissions;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class DeleteUserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_user_permission()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $userPermission = UserPermission::create(['role' => 'user', 'routeName' => 'mock']);

        Livewire::test(UserPermissions::class)
            ->set('modelId', $userPermission->id)
            ->call('delete');

        $this->assertTrue(!UserPermission::find($userPermission->id));
    }

    public function test_delete_user_permission_not_found()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(UserPermissions::class)
            ->set('modelId', 1)
            ->call('delete');

        $this->assertTrue(!UserPermission::find(1));
    }
}

<?php

namespace Tests\Feature\Admin\UserPermissions;

use App\Http\Livewire\UserPermissions;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadUserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_permissions_screen_can_be_rendered()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $response = $this->get('/user-permissions');

        $response->assertStatus(200);
    }

    public function test_read_user_permission()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        UserPermission::create(['role' => 'user', 'routeName' => 'mock']);

        $component = new UserPermissions();
        $result = $component->read();

        $expected = UserPermission::paginate(5);

        $this->assertEquals($expected, $result);
    }

    public function test_create_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $component = new UserPermissions();
        $component->createShowModal();

        $this->assertTrue($component->modalFormVisible);
    }

    public function test_update_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $userPermisson = UserPermission::create(['role' => 'user', 'routeName' => 'mock']);

        $component = new UserPermissions();

        $component->updateShowModal($userPermisson->id);

        $this->assertTrue($component->modalFormVisible);
    }

    public function test_delete_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $userPermisson = UserPermission::create(['role' => 'user', 'routeName' => 'mock']);

        $component = new UserPermissions();
        $component->deleteShowModal($userPermisson->id);

        $this->assertTrue($component->modalConfirmDeleteVisible);
    }
}

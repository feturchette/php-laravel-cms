<?php

namespace Tests\Feature\Admin\Users;

use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_screen_can_be_rendered()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $response = $this->get('/users');

        $response->assertStatus(200);
    }

    public function test_read_user()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        User::factory()->create(['role' => 'user']);

        $component = new Users();
        $result = $component->read();

        $expected = User::paginate(5);

        $this->assertEquals($expected, $result);
    }

    public function test_create_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $component = new Users();
        $component->createShowModal();

        $this->assertTrue($component->modalFormVisible);
    }

    public function test_update_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $user = $user = User::factory()->create(['role' => 'user']);

        $component = new Users();

        $component->updateShowModal($user->id);

        $this->assertTrue($component->modalFormVisible);
    }

    public function test_delete_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $user = User::factory()->create(['role' => 'user']);

        $component = new Users();
        $component->deleteShowModal($user->id);

        $this->assertTrue($component->modalConfirmDeleteVisible);
    }
}

<?php

namespace Tests\Feature\Admin\Users;

use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_user()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $user = User::factory()->create(['role' => 'user']);

        Livewire::test(Users::class)
            ->set('modelId', $user->id)
            ->set('role', 'editor')
            ->set('name', 'Mock')
            ->call('update');

        $this->assertTrue(User::whereRole('editor')->exists());
    }

    public function test_update_user_role_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $user = User::factory()->create(['role' => 'user']);

        Livewire::test(Users::class)
            ->set('modelId', $user->id)
            ->set('role', '')
            ->set('name', 'Mock')
            ->call('update')
            ->assertHasErrors('role');
    }

    public function test_update_user_name_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        
        $user = User::factory()->create(['role' => 'user']);

        Livewire::test(Users::class)
            ->set('modelId', $user->id)
            ->set('role', 'editor')
            ->set('name', '')
            ->call('update')
            ->assertHasErrors('name');
    }
}

<?php

namespace Tests\Feature\Admin\Users;

use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_user()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $user = User::factory()->create(['role' => 'user']);

        Livewire::test(Users::class)
            ->set('modelId', $user->id)
            ->call('delete');

        $this->assertFalse(User::whereRole('user')->exists());
    }

    public function test_delete_user_not_found()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Users::class)
            ->set('modelId', 1)
            ->call('delete');

        $this->assertTrue(!User::find(1));
    }
}

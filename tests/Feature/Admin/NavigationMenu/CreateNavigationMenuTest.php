<?php

namespace Tests\Feature\Admin\NavigationMenu;

use App\Http\Livewire\NavigationMenus;
use App\Models\User;
use App\Models\NavigationMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class CreateNavigationMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_new_menu()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(NavigationMenus::class)
            ->set('label', 'Foo')
            ->set('slug', 'foo')
            ->set('sequence', 1)
            ->set('type', 'SidebarNav')
            ->call('create');

        $this->assertTrue(NavigationMenu::whereSlug('foo')->exists());
    }

    public function test_create_new_menu_with_defaults()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(NavigationMenus::class)
            ->set('label', 'Foo')
            ->call('create');

        $this->assertTrue(NavigationMenu::whereSlug('foo')->exists());
    }

    public function test_new_menu_label_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(NavigationMenus::class)
            ->set('slug', 'foo')
            ->set('sequence', 1)
            ->set('type', 'SidebarNav')
            ->call('create')
            ->assertHasErrors('label');
    }

    public function test_new_menu_slug_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(NavigationMenus::class)
            ->set('sequence', 1)
            ->set('type', 'SidebarNav')
            ->call('create')
            ->assertHasErrors('slug');
    }
}

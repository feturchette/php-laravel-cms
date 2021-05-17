<?php

namespace Tests\Feature\Admin\NavigationMenu;

use App\Http\Livewire\NavigationMenus;
use App\Models\User;
use App\Models\NavigationMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class UpdateNavigationMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_menu()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $menu = $this->createMenu();

        Livewire::test(NavigationMenus::class)
            ->set('modelId', $menu->id)
            ->set('label', 'Mock')
            ->set('slug', 'mock')
            ->set('sequence', 1)
            ->set('type', 'SidebarNav')
            ->call('update');

        $this->assertTrue(NavigationMenu::whereSlug('mock')->exists());
    }

    public function test_update_new_menu_with_defaults()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $menu = $this->createMenu();

        Livewire::test(NavigationMenus::class)
            ->set('modelId', $menu->id)
            ->set('label', 'Mock')
            ->call('update');

        $this->assertTrue(NavigationMenu::whereSlug('mock')->exists());
    }

    public function test_update_menu_label_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $menu = $this->createMenu();

        Livewire::test(NavigationMenus::class)
            ->set('modelId', $menu->id)
            ->set('label', '')
            ->set('slug', 'foo')
            ->set('sequence', 1)
            ->set('type', 'SidebarNav')
            ->call('update')
            ->assertHasErrors('label');
    }

    public function test_update_menu_slug_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        
        $menu = $this->createMenu();

        Livewire::test(NavigationMenus::class)
            ->set('modelId', $menu->id)
            ->set('label', 'foo')
            ->set('slug', '')
            ->set('sequence', 1)
            ->set('type', 'SidebarNav')
            ->call('update')
            ->assertHasErrors('slug');
    }

    private function createMenu()
    {
        return NavigationMenu::create([
            'label' => 'Foo',
            'slug' => 'foo',
            'sequence' => 1,
            'type' => 'SidebarNav'
        ]);
    }
}

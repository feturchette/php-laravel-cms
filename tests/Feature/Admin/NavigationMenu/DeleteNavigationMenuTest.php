<?php

namespace Tests\Feature\Admin\NavigationMenu;

use App\Http\Livewire\NavigationMenus;
use App\Models\User;
use App\Models\NavigationMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class DeleteNavigationMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_menu()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $menu = $this->createMenu();

        Livewire::test(NavigationMenus::class)
            ->set('modelId', $menu->id)
            ->call('delete');

        $this->assertFalse(NavigationMenu::whereSlug('foo')->exists());
    }

    public function test_delete_menu_not_found()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(NavigationMenus::class)
            ->set('modelId', 1)
            ->call('delete');

        $this->assertTrue(!NavigationMenu::find(1));
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

<?php

namespace Tests\Feature\Admin\NavigationMenu;

use App\Http\Livewire\NavigationMenus;
use App\Models\User;
use App\Models\NavigationMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadNavigationMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_screen_can_be_rendered()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $response = $this->get('/navigation-menus');

        $response->assertStatus(200);
    }

    public function test_read_menu()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->createMenu();

        $navigationMenus = new NavigationMenus();
        $result = $navigationMenus->read();

        $expected = NavigationMenu::paginate(5);

        $this->assertEquals($expected, $result);
    }

    public function test_create_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $navigationMenus = new NavigationMenus();
        $navigationMenus->createShowModal();

        $this->assertTrue($navigationMenus->modalFormVisible);
    }

    public function test_update_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $menu = $this->createMenu();

        $navigationMenus = new NavigationMenus();
        $navigationMenus->read();

        $navigationMenus->updateShowModal($menu->id);

        $this->assertTrue($navigationMenus->modalFormVisible);
    }

    public function test_delete_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $menu = $this->createMenu();

        $navigationMenus = new NavigationMenus();
        $navigationMenus->read();

        $navigationMenus->deleteShowModal($menu->id);

        $this->assertTrue($navigationMenus->modalConfirmDeleteVisible);
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

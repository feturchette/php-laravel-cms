<?php

namespace Tests\Feature\Admin\Pages;

use App\Http\Livewire\Pages;
use App\Models\User;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_screen_can_be_rendered()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $response = $this->get('/pages');

        $response->assertStatus(200);
    }

    public function test_read_page()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        $component = new Pages();
        $result = $component->read();

        $expected = Page::paginate(5);

        $this->assertEquals($expected, $result);
    }

    public function test_create_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $component = new Pages();
        $component->createShowModal();

        $this->assertTrue($component->modalFormVisible);
    }

    public function test_update_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $page = Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        $component = new Pages();

        $component->updateShowModal($page->id);

        $this->assertTrue($component->modalFormVisible);
    }

    public function test_delete_show_modal()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $page = Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        $component = new Pages();
        $component->deleteShowModal($page->id);

        $this->assertTrue($component->modalConfirmDeleteVisible);
    }
}

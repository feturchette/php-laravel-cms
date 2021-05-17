<?php

namespace Tests\Feature\Admin\Pages;

use App\Http\Livewire\Pages;
use App\Models\User;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class UpdatePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_page()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $page = Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        Livewire::test(Pages::class)
            ->set('modelId', $page->id)
            ->set('title', 'Foo')
            ->set('content', 'mock')
            ->call('update');

        $this->assertTrue(Page::whereSlug('foo')->exists());
    }

    public function test_update_page_title_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $page = Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        Livewire::test(Pages::class)
            ->set('modelId', $page->id)
            ->set('content', 'mock')
            ->call('update')
            ->assertHasErrors('title');
    }

    public function test_update_page_slug_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        
        $page = Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        Livewire::test(Pages::class)
            ->set('modelId', $page->id)
            ->set('content', 'mock')
            ->call('update')
            ->assertHasErrors('slug');
    }

    public function test_update_page_content_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        
        $page = Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        Livewire::test(Pages::class)
            ->set('modelId', $page->id)
            ->call('update')
            ->assertHasErrors('content');
    }
}

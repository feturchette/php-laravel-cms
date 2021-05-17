<?php

namespace Tests\Feature\Admin\Pages;

use App\Http\Livewire\Pages;
use App\Models\User;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class DeletePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_page()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $page = Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        Livewire::test(Pages::class)
            ->set('modelId', $page->id)
            ->call('delete');

        $this->assertTrue(!Page::find($page->id));
    }

    public function test_delete_page_not_found()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Pages::class)
            ->set('modelId', 1)
            ->call('delete');

        $this->assertTrue(!Page::find(1));
    }
}

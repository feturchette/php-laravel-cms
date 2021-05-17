<?php

namespace Tests\Feature\Admin\Pages;

use App\Http\Livewire\Pages;
use App\Models\User;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class CreatePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_new_page()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Pages::class)
            ->set('title', 'Foo')
            ->set('content', 'mock')
            ->call('create');

        $this->assertTrue(Page::whereTitle('Foo')->exists());
    }

    public function test_create_page_home()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Pages::class)
            ->set('title', 'Home')
            ->set('slug', 'home')
            ->set('content', 'mock')
            ->set('isSetToDefaultHomePage', true)
            ->call('create');
        
        $formerHomepage = Page::whereIsDefaultHome(true)->first();
        $this->assertFalse(!$formerHomepage);
        
        Livewire::test(Pages::class)
            ->set('title', 'newHome')
            ->set('slug', 'mock')
            ->set('content', 'mock')
            ->set('isSetToDefaultHomePage', true)
            ->call('create');
        
        $newHomepage = Page::whereIsDefaultHome(true)->first();

        $this->assertTrue($newHomepage->id !== $formerHomepage->id);
        $this->assertEquals(1, Page::whereIsDefaultHome(true)->count());
    }

    public function test_create_page_not_found()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Pages::class)
            ->set('title', 'Home')
            ->set('slug', 'home')
            ->set('content', 'mock')
            ->set('isSetToDefaultNotFoundPage', true)
            ->call('create');
        
        $formerNotFound = Page::whereIsDefaultNotFound(true)->first();
        $this->assertFalse(!$formerNotFound);
        
        Livewire::test(Pages::class)
            ->set('title', 'newHome')
            ->set('slug', 'mock')
            ->set('content', 'mock')
            ->set('isSetToDefaultNotFoundPage', true)
            ->call('create');
        
        $newNotFound = Page::whereIsDefaultNotFound(true)->first();

        $this->assertTrue($newNotFound->id !== $formerNotFound->id);
        $this->assertEquals(1, Page::whereIsDefaultNotFound(true)->count());
    }

    public function test_create_page_slug_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Pages::class)
            ->set('content', 'mock')
            ->call('create')
            ->assertHasErrors('slug');
    }

    public function test_create_page_title_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Pages::class)
            ->set('content', 'mock')
            ->call('create')
            ->assertHasErrors('title');
    }

    public function test_create_page_content_required_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(Pages::class)
            ->set('title', 'Foo')
            ->call('create')
            ->assertHasErrors('content');
    }

    public function test_create_page_slug_unique_validation()
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Page::create(['slug' => 'mock', 'title' => 'Mock', 'content' => 'mock']);

        Livewire::test(Pages::class)
            ->set('title', 'Mock')
            ->set('slug', 'mock')
            ->set('content', 'mock')
            ->call('create')
            ->assertHasErrors('slug');
    }
}

<?php

namespace Tests\Feature\Admin\Frontpage;

use App\Models\User;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoadFrontPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_frontpage_screen_can_be_rendered()
    {
        $this->actingAs(User::factory()->create(['role' => 'user']));

        Page::create(['slug' => 'foo', 'title' => 'Foo', 'content' => 'bar']);

        Page::create([
            'slug' => 'home', 
            'title' => 'Home', 
            'content' => 'home', 
            'is_default_home' => true
        ]);

        Page::create([
            'slug' => 'not-found', 
            'title' => 'Not Found', 
            'content' => 'not found',
            'is_default_not_found' => true
        ]);

        $response = $this->get('/foo');
        $response->assertSee('Foo');
        $response->assertSee('bar');
        $response->assertStatus(200);

        $response = $this->get('/bar');
        $response->assertSee('Not Found');
        $response->assertSee('not found');
        $response->assertStatus(200);

        $response = $this->get('/');
        $response->assertSee('Home');
        $response->assertSee('home');
        $response->assertStatus(200);
    }
}
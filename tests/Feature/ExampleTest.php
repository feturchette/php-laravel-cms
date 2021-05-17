<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        DB::table('pages')->insert([
            'title' => 'Home test',
            'slug' => 'home',
            'content' => 'Welcome to the Home page',
            'is_default_home' => true
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

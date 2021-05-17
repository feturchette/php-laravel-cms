<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->userSeed();
        $this->pageSeed();
        $this->menuSeed();
    }

    private function userSeed() {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@cms.com',
            'password' => Hash::make('cmspassword'),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'editor',
            'email' => 'editor@cms.com',
            'password' => Hash::make('cmspassword'),
            'role' => 'editor',
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@cms.com',
            'password' => Hash::make('cmspassword'),
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@cms.com',
            'password' => Hash::make('cmspassword'),
        ]);
    }

    private function pageSeed() {
        DB::table('pages')->insert([
            'title' => 'Home',
            'slug' => 'home',
            'content' => 'Welcome to the Home page',
            'is_default_home' => true
        ]);

        DB::table('pages')->insert([
            'title' => 'About',
            'slug' => 'about',
            'content' => 'Welcome to the About page',
        ]);

        DB::table('pages')->insert([
            'title' => 'Articles',
            'slug' => 'articles',
            'content' => 'Read articles',
        ]);

        DB::table('pages')->insert([
            'title' => 'Not Found',
            'slug' => 'not-found',
            'content' => '404 - Page not found',
            'is_default_not_found' => true,
        ]);

        DB::table('user_permissions')->insert([
            'role' => 'editor',
            'route_name' => 'dashboard',
        ]);

        DB::table('user_permissions')->insert([
            'role' => 'editor',
            'route_name' => 'menus',
        ]);

        DB::table('user_permissions')->insert([
            'role' => 'editor',
            'route_name' => 'pages',
        ]);
    }

    private function menuSeed() {
        DB::table('navigation_menus')->insert([
            'label' => 'Home',
            'slug' => 'home',
            'sequence' => 1,
            'type' => 'SidebarNav'
        ]);

        DB::table('navigation_menus')->insert([
            'label' => 'About',
            'slug' => 'about',
            'sequence' => 2,
            'type' => 'SidebarNav'
        ]);

        DB::table('navigation_menus')->insert([
            'label' => 'Articles',
            'slug' => 'articles',
            'sequence' => 3,
            'type' => 'SidebarNav'
        ]);
    }
}

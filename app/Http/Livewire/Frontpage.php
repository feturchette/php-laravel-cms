<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class Frontpage extends Component
{
    public $title;
    public $content;

    public function mount($slug = null)
    {
        if (is_null($slug)) {
            $page = Page::where('is_default_home', true)->first();
        } else {
            $page = Page::where('slug', $slug)->first();

            if(!$page) {
                $page = Page::where('is_default_not_found', true)->first();
            }
        }

        $this->title = $page->title;
        $this->content = $page->content;
    }

    public function render()
    {
        return view('livewire.frontpage', [
            'sideBarLinks' => $this->sideBarLinks(),
            'topNavLinks' => $this->topNavLinks(),
        ])->layout('layouts.frontpage');
    }

    private function sideBarLinks()
    {
        return DB::table('navigation_menus')
            ->where('type', '=', 'SidebarNav')
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function topNavLinks()
    {
        return DB::table('navigation_menus')
            ->where('type', '=', 'TopNav')
            ->orderBy('sequence', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
    }
}

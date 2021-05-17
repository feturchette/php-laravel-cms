<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;
use App\Http\Livewire\Traits\CanCreate;
use Illuminate\Support\Str;

class NavigationMenus extends BaseComponent
{
    use CanCreate;

    public $label;
    public $slug;
    public $sequence = 1;
    public $type = 'SidebarNav';

    protected $modelClass = 'NavigationMenu';

    public function rules()
    {
        return [
            'label' => 'required',
            'slug' => 'required',
            'sequence' => 'required',
            'type' => 'required',
        ];
    }

    public function loadModel()
    {
        $data = NavigationMenu::find($this->modelId);
        $this->label = $data->label;
        $this->slug = $data->slug;
        $this->type = $data->type;
        $this->sequence = $data->sequence;
    }

    public function modelData()
    {
        return [
            'label' => $this->label,
            'slug' => strip_tags($this->slug),
            'sequence' => $this->sequence,
            'type' => $this->type,
        ];
    }

    public function updatedLabel(string $value)
    {
        $this->slug = Str::slug($value);
    }

    public function render()
    {
        return view('livewire.navigation-menus', [
            'data' => $this->read(),
        ]);
    }
}
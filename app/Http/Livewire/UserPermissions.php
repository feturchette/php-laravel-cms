<?php

namespace App\Http\Livewire;

use App\Models\UserPermission;
use App\Http\Livewire\Traits\CanCreate;

class UserPermissions extends BaseComponent
{
    use CanCreate;

    public $role;
    public $routeName;

    protected $modelClass = 'UserPermission';

    public function rules()
    {
        return [
            'role' => 'required',
            'routeName' => 'required',
        ];
    }

    public function loadModel()
    {
        $data = UserPermission::find($this->modelId);
        
        $this->role = $data->role;
        $this->routeName = $data->route_name;
    }

    public function modelData()
    {
        return [
            'role' => $this->role,
            'route_name' => $this->routeName,
        ];
    }

    public function render()
    {
        return view('livewire.user-permissions', [
            'data' => $this->read(),
        ]);
    }
}
<?php

namespace App\Http\Livewire;

use App\Models\User;

class Users extends BaseComponent
{
    public $role;
    public $name;

    protected $modelClass = 'User';

    public function rules()
    {
        return [
            'role' => 'required',
            'name' => 'required',
        ];
    }

    public function loadModel()
    {
        $data = User::find($this->modelId);
        $this->role = $data->role;
        $this->name = $data->name;
    }

    public function modelData()
    {
        return [
            'role' => $this->role,
            'name' => $this->name,
        ];
    }

    public function render()
    {
        return view('livewire.users', [
            'data' => $this->read(),
        ]);
    }
}
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\CanUpdate;
use App\Http\Livewire\Traits\CanDelete;

abstract class BaseComponent extends Component
{
    use WithPagination;
    use CanUpdate;
    use CanDelete;

    public $modelId;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;

    protected $model;
    protected $modelClass;

    public function read()
    {
        $this->loadModelClass();
        return $this->model::paginate(5);
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->modelId = $id;
        $this->loadModel();
    }

    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }
    
    public function loadModelClass()
    {
      $this->model = "\App\\Models\\".ucwords($this->modelClass);
      if(!class_exists($this->model)){
          abort(500, 'Model does not exist');
      }
    }
}
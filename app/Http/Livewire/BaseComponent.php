<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\CanUpdate;
use App\Http\Livewire\Traits\CanDelete;
use \Exception;
use Illuminate\Support\Facades\Log;

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
        try {
            $this->loadModelClass();
            return $this->model::paginate(5);
        } catch(Exception $e) {
            Log::error('Error trying to read ' .$this->modelClass. ' - ' . $e->getMessage());
            throw $e;
        }
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
          abort(500, 'Model '.$this->modelClass.' does not exist');
      }
    }
}
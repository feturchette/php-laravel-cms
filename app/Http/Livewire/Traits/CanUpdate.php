<?php

namespace App\Http\Livewire\Traits;
use Exception;
use Illuminate\Support\Facades\Log;

trait CanUpdate
{
  public function update()
  {
      try {
        $this->validate();
        $this->loadModelClass();
        $this->model::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
      } catch(Exception $e) {
        Log::error('Error trying to delete ' .$this->modelClass. ' - ' . $e->getMessage());
        throw $e;
      }
  }
}
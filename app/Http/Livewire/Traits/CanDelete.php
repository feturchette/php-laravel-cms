<?php

namespace App\Http\Livewire\Traits;
use Exception;
use Illuminate\Support\Facades\Log;

trait CanDelete
{
  public function delete()
  {
      try {
        $this->loadModelClass();
        $this->model::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
      } catch(Exception $e) {
        Log::error('Error trying to delete ' .$this->modelClass. ' - ' . $e->getMessage());
        throw $e;
      }
  }
}
<?php

namespace App\Http\Livewire\Traits;
use Exception;
use Illuminate\Support\Facades\Log;

trait CanCreate
{
  public function create()
  {
    try {
      $this->validate();
      $this->loadModelClass();
      $this->model::create($this->modelData());
      $this->modalFormVisible = false;
      $this->reset();
    } catch(Exception $e) {
      Log::error('Error trying to delete ' .$this->modelClass. ' - ' . $e->getMessage());
      throw $e;
    }
  }
}
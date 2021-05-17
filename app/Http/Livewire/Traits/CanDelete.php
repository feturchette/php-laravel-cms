<?php

namespace App\Http\Livewire\Traits;

trait CanDelete
{
  public function delete()
  {
      $this->loadModelClass();
      $this->model::destroy($this->modelId);
      $this->modalConfirmDeleteVisible = false;
      $this->resetPage();
  }
}
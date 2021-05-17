<?php

namespace App\Http\Livewire\Traits;

trait CanUpdate
{
  public function update()
  {
      $this->validate();
      $this->loadModelClass();
      $this->model::find($this->modelId)->update($this->modelData());
      $this->modalFormVisible = false;
  }
}
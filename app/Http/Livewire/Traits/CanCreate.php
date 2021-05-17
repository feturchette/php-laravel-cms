<?php

namespace App\Http\Livewire\Traits;

trait CanCreate
{
  public function create()
  {
      $this->validate();
      $this->loadModelClass();
      $this->model::create($this->modelData());
      $this->modalFormVisible = false;
      $this->reset();
  }
}
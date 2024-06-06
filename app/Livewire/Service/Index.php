<?php

namespace App\Livewire\Service;

use Livewire\Component;
use App\Models\Service;

class Index extends Component
{
    public $search;

    protected $listeners = ['reload' => '$refresh'];

    public $no = 1;

    public function render()
    {
        return view('livewire.service.index', [
            
            'services'  => Service::when($this->search, function($service){
                $service->where('name', 'like', '%'.$this->search.'%');
            })->get()

        ]);
       
    }
}

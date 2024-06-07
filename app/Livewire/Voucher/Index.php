<?php

namespace App\Livewire\Voucher;

use App\Models\Voucher;
use Livewire\Component;

class Index extends Component
{
    public $search;

    protected $listeners = ['reload' => '$refresh'];

    public $no = 1;

    public function render()
    {
        return view('livewire.voucher.index', [
            
            'vouchers'  => Voucher::when($this->search, function($service){
                $service->where('name', 'like', '%'.$this->search.'%');
            })->get()

        ]);
    }
}

<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;


class Index extends Component
{
    public $no = 1;

    public $date;
   
    protected $listeners = ['reload' => '$refresh'];

    public function mount()
    {
        $this->date = date('Y-m-d');
    }
    

    public function render()
    {
        
        return view('livewire.transaksi.index', [

            'transaksis' => Transaksi::orderBy('created_at', 'desc')
                ->when($this->date, function($query) {
                    $query->whereDate('created_at', $this->date);
                        })->get()
                ]);
    
    }
}

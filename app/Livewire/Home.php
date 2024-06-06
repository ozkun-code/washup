<?php

namespace App\Livewire;

use App\Models\Transaksi;
use Livewire\Component;

class Home extends Component
{
    
    protected $listeners = ['reload' => '$refresh'];
    public function render()
{
    $today = date('Y-m-d');
    [$tahun,$bulan] = explode('-', date('Y-m'));
    $transaksi = Transaksi::whereMonth('created_at',$bulan)->whereYear('created_at',$tahun);
    return view('livewire.home',[
        
        'monthly' => $transaksi->get()->sum('price'),
        'today' => $transaksi->whereDate('created_at',$today)->get()->sum('price'),
        'todayCount' => $transaksi->whereDate('created_at',$today)->count(),
        'datas' => Transaksi::where('status', '<>', 'sudah diambil')->orderBy('created_at', 'desc')->get(),

    ]);
}
}

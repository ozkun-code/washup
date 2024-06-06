<?php

namespace App\Livewire\Transaksi;

use App\Livewire\Forms\TransaksiForm;
use App\Models\Transaksi;
use Livewire\Component;
use Livewire\Attributes\on;

class Update extends Component
{
    public TransaksiForm $form;
    public $show = false;

    #[On('editTransaksi')]
    public function editTransaksi(Transaksi $transaksi)
    {
        $this->form->setTransaksi($transaksi);
        $this->show = true;
        $this->dispatch('reload');
    }

    public function closeModal()
    {
        $this->show = false;
        $this->form->reset();
    }

    public function updateStatus()
    {
        $this->form->update();
        $this->closeModal();
        $this->dispatch('reload');    
    }

    public function render()
    {
        return view('livewire.transaksi.update', [
            'statuss' => Transaksi::$status,
        ]);
    }
}
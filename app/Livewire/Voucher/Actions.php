<?php

namespace App\Livewire\Voucher;

use App\Livewire\Forms\VoucherForm;
use App\Models\Voucher;
use Livewire\Component;
use Livewire\Attributes\On;

class Actions extends Component
{
    public $show = false;
    
    public ?Voucher $voucher = null;
    
    public VoucherForm $form;
    

    #[On('createVoucher')]
    public function createVoucher()
    {
        $this->show = true;
    }

    #[On('editVoucher')]
    public function editVoucher(Voucher $voucher)
    {   
        $this->form->setVoucher($voucher);
        
        $this->show = true;

        $this->dispatch('reload');
    }

    #[On('deleteVoucher')]
    public function deleteVoucher(Voucher $voucher)
    {   
        $voucher->delete();

        $this->dispatch('reload');
    }

    public function simpan()
    {
        if ($this->form->id === null) {
            $this->form->store();
        } else {
            $this->form->update();
        }

        $this->closeModal();
        $this->dispatch('reload');
    }

    public function closeModal()
    {
        $this->show = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.voucher.actions');
    }
}
<?php

namespace App\Livewire\Customer;

use App\Livewire\Forms\CustomerForm;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\ValidationException;

use Livewire\WithFileUploads;

class Actions extends Component
{
    use WithFileUploads;

    public $show = false;
    
    public ?User $user = null;
    
    public CustomerForm $form;

    #[On('createCustomer')]
    public function createCustomer()
    {
        $this->show = true;
    }

    #[On('editCustomer')]
    public function editCustomer(Customer $customer)
    {   
        $this->form->setCustomer($customer);
        
        $this->show = true;

        $this->dispatch('reload');
    }

    #[On('deletCustomer')]
    public function deleteCustomer(Customer $customer)
    {   
        // Retrieve the associated user
        $user = User::find($customer->user_id);

        $customer->delete();

        $user->delete();

        $this->dispatch('reload');
    }


    public function simpan()
    {
        if ($this->form->user_id === null) {
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
        return view('livewire.customer.actions');
    }
}
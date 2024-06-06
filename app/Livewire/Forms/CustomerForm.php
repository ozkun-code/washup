<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Form;

class CustomerForm extends Form
{
    public $name;
    public $contact;
    public $user_email;
    public $user_id;
    public ?User $user = null;
    public ?Customer $customer;

    public function setCustomer(Customer $customer)
    {
        $user = $customer->user()->first();

        $this->customer = $customer;
        $this->name = $customer->name;
        $this->contact = $customer->contact;
        $this->user_email = $user->email;
        $this->user_id = $user->id;
    }

    public function store()
    {
        $validate = $this->validate([
            'name' => 'required',
            'contact' => 'required',
            'user_email' => 'required',
        ]);

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['user_email'],
            'password' => Hash::make('washup'),
            'role' => 'customer',
        ]);

        Customer::create([
            'name' => $validate['name'],
            'contact' => $validate['contact'],
            'user_id' => $user->id,
        ]);

        $this->reset();
    }

    public function update()
    {
        $validate = $this->validate([
            'name' => 'required',
            'contact' => 'required',
            'user_email' => 'required|email'
        ]);

        $this->customer->user()->update(['email' => $validate['user_email']]);
        $this->customer->update($validate);

        $this->reset();
    }
}
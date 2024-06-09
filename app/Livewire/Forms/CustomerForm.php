<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

    // Buat password secara acak
    $randomPassword = Str::random(10);

    $user = User::create([
        'name' => $validate['name'],
        'email' => $validate['user_email'],
        'password' => Hash::make($randomPassword),
        'role' => 'customer',
    ]);

    Customer::create([
        'name' => $validate['name'],
        'contact' => $validate['contact'],
        'user_id' => $user->id,
    ]);

    // Kirim pesan WhatsApp setelah pengguna berhasil didaftarkan
    $curl = curl_init();

    $message = "Registrasi member Washup Anda berhasil.\nUsername: " . $validate['name'] . "\nPassword: " . $randomPassword . "\nSilahkan ubah password setelah Anda login.";

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('target' => $validate['contact'], 'message' => $message),
        CURLOPT_HTTPHEADER => array(
            'Authorization: QpLdLPJWyNtmD-rP9eSo'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

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
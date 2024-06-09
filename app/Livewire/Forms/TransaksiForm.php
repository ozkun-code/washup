<?php

namespace App\Livewire\Forms;

use App\Models\StatusLog;
use App\Models\Transaksi;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TransaksiForm extends Form
{
    public $customer_id;
    public $description;
    public $items;
    public $discount;
    public $price;
    public $status;
    public $created_at;
    public ?Transaksi $transaksi;
    
    public function setTransaksi(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;

        $this->customer_id = $transaksi->customer_id;
        $this->description = $transaksi->description;
        $this->items = $transaksi->items;
        $this->price = $transaksi->price;
        $this->status = $transaksi->status;
        $this->discount = $transaksi->discount;
        $this->created_at = $transaksi->created_at;
    }

    public function store ()
    {
        $validate = $this->validateData();

        $transaksi = Transaksi::create($validate);
        $this->createStatusLog($transaksi->id, 'dibayar');

        $this->reset();
    }

    public function update ()
    {
        $validate = $this->validateData(true);

        $this->transaksi->update($validate);
        $this->createStatusLog($this->transaksi->id, $this->status);

        $this->reset();
    }

    private function validateData($isUpdate = false)
    {
        $rules = [
            'customer_id' => $isUpdate ? 'required' : '',
            'description' => 'required',
            'items' => 'required',
            'price' => 'required',
            'discount' => 'required',
        ];

        if ($isUpdate) {
            $rules['status'] = 'required';
        }

        $validate = $this->validate($rules);
        $validate['items'] = json_encode($validate['items']);

        return $validate;
    }

    private function createStatusLog($transaksiId, $status)
    {
        StatusLog::create([
            'transaksi_id' => $transaksiId,
            'status' => $status,
            'changed_at' => now(),
        ]);
    }
}
<?php

namespace App\Livewire\Forms;

use App\Models\Voucher;
use Livewire\Attributes\Validate;   
use Livewire\Form;

class VoucherForm extends Form
{
    public $name;
    public $discount_percent;
    public $points_required;
    public $id;

    public ?Voucher $voucher;

    public function setVoucher(Voucher $voucher)
    {
        $this->voucher = $voucher;

        $this->id = $voucher->id;
        $this->name = $voucher->name;
        $this->discount_percent = $voucher->discount_percent;
        $this->points_required = $voucher->points_required;
    }

    public function store()
    {
        $validate = $this->validateData();

        Voucher::create($validate);
        $this->reset();
    }

    public function update()
    {
        $validate = $this->validateData();

        $this->voucher->update($validate);
        $this->reset();
    }

    protected function validateData()
    {
        return $this->validate([
            'name' => 'required',
            'discount_percent' => 'required',
            'points_required' => 'required',
        ]);
    }
}
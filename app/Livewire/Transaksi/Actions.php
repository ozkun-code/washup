<?php

namespace App\Livewire\Transaksi;

use App\Livewire\Forms\TransaksiForm;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Voucher;
use App\Models\ClaimedVoucher;
use Livewire\Component;

class Actions extends Component
{
    public $search;
    public $items = [];
    public $voucherNames = [];
    public $vouchers = [];
    public TransaksiForm $form;
    public $customerId;
    public $discount = 0;
    public $selectedVoucher;
    public $voucher_id;
   
   
  
    public function addVoucher()
    {
        $customer = Customer::find($this->form->customer_id);
    
        if ($customer) {
            $claimedVouchers = ClaimedVoucher::where('user_id', $customer->user_id)
                                             ->whereNull('used_at')
                                             ->get();
    
            foreach ($claimedVouchers as $claimedVoucher) {
                $voucherName = Voucher::find($claimedVoucher->voucher_id);
                $this->voucherNames[] = $voucherName;
            }
        } else {
            dd('Customer not found');
        }
    }


 
    public function addItem(Service $service)
    {
        if (isset($this->items[$service->name])) {
            $item = $this->items[$service->name];
            $this->items[$service->name] = [
                'qty' => $item['qty'] + 1,
                'price' => $item['price'] + $service->price,
                'unit' => $service->unit
            ];
        } else {
            $this->items[$service->name] = [
                'qty' => 1,
                'price' => $service->price,
                'unit' => $service->unit
            ];
        }
    }
    public function applyVoucher()
{
    $voucher = Voucher::find($this->selectedVoucher);

    if ($voucher) {
       
        $this->discount = $voucher->discount_percent;
    } else {
       
        $this->discount = null;
    }

}

public function getPrice()
{
    $prices = array_column($this->items, 'price');
    $totalPrice = array_sum($prices);

    // Apply the discount
    $discountedPrice = $totalPrice - ($totalPrice * ($this->discount / 100));

    return $discountedPrice;
}

    public function removeItem($key)
    {
        $item = $this->items[$key];
        if ($item['qty'] > 1) {
            $harga = $item['price'] / $item['qty'];
            $qtybaru = $item['qty'] - 0.1;
            $this->items[$key]['qty'] = $qtybaru;
            $this->items[$key]['price'] = $harga * $qtybaru;
        } else {
            unset($this->items[$key]);
        }
    }

    public function plusItem($key)
    {
        $item = $this->items[$key];
        $harga = $item['price'] / $item['qty'];
        $qtybaru = $item['qty'] + 0.1;
        $this->items[$key]['qty'] = $qtybaru;
        $this->items[$key]['price'] = $harga * $qtybaru;
    }

    public function simpan()
{
    
    
    $this->validate([
        'items' => 'required',
    ]);

    $this->form->items = $this->items;
    $this->form->price = $this->getPrice();
    $this->form->voucher_id = $this->selectedVoucher;
    $this->form->discount = $this->discount;
    $this->form->store();

    return redirect()->route('transaksi.index');
}

    public function render()
    {
        return view('livewire.transaksi.actions', [
            'services' => Service::when($this->search, function($service){
                $service->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhere('price', 'like', '%'.$this->search.'%');
            })->get()->groupBy('unit'),
            'customers' => Customer::pluck('name', 'id'),
           
        ]);
    }
}

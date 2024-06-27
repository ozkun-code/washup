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
                ->with('voucher:id,name')
                ->get();
    
            $this->voucherNames = $claimedVouchers->map(function ($claimedVoucher) {
                return [
                    'id' => $claimedVoucher->id,
                'voucher_id' => $claimedVoucher->voucher->id,
                'voucher_name' => $claimedVoucher->voucher->name
                ];
            })->toArray();
            
           
        } else {
            dd('Customer not found');
        }
    }


 
    public function addItem(Service $service)
{
    $name = $service->name;
    if (!isset($this->items[$name])) {
        $this->items[$name] = ['qty' => 0, 'price' => 0, 'unit' => $service->unit];
    }

    $this->items[$name]['qty'] += 1;
    $this->items[$name]['price'] += $service->price;
}
    public function applyVoucher()
    {
        $claimedVoucher = ClaimedVoucher::find($this->selectedVoucher);
    
        if ($claimedVoucher) {
            $voucher = Voucher::find($claimedVoucher->voucher_id);
    
            if ($voucher) {
                $this->discount = $voucher->discount_percent;
            } else {
                $this->discount = null;
            }
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

public function adjustItemQuantity($key, $adjustment)
{
    $item = $this->items[$key];
    $newQty = $item['qty'] + $adjustment;
    if ($newQty > 0) {
        $pricePerUnit = $item['price'] / $item['qty'];
        $this->items[$key]['qty'] = $newQty;
        $this->items[$key]['price'] = $pricePerUnit * $newQty;
    } else {
        unset($this->items[$key]);
    }
}

public function removeItem($key)
{
    $this->adjustItemQuantity($key, -0.1);
}

public function plusItem($key)
{
    $this->adjustItemQuantity($key, 0.1);
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

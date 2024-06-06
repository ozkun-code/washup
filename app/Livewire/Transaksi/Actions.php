<?php

namespace App\Livewire\Transaksi;

use App\Livewire\Forms\TransaksiForm;
use App\Models\Customer;
use App\Models\Service;
use Livewire\Component;

class Actions extends Component
{
    public $search;
    public $items = [];
    public TransaksiForm $form;

    
public function addItem(Service $service)
{
    if (isset($this->items[$service->name])){
        $item = $this->items[$service->name];
        $this->items[$service->name] = [
            'qty' => $item['qty'] + 1,
            'price' => $item['price'] + $service->price,
            'unit' => $service->unit
        ];
    }
    else{
        $this->items[$service->name] = [
            'qty' => 1,
            'price' => $service->price,
            'unit' => $service->unit
        ];
    }
}
    public function getPrice()
    {
        $prices = array_column($this->items, 'price');
        return array_sum($prices);
    }
    public function removeItem($key)
    {
       $item = $this->items[$key];
       if ($item['qty'] > 1){
        $harga = $item['price'] / $item['qty'];
        $qtybaru = $item['qty'] -0.1;

           $this->items[$key]['qty'] = $qtybaru;
           $this->items[$key]['price'] = $harga * $qtybaru;
       
       }
       else{
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

    $this->form->store();

 
    emotify('success', 'Transaksi berhasil dibuat');
    return redirect()->route('transaksi.actions');
 
    
}
    public function closeAlert()
    {
        $this->dispatch('reload');
    }



    public function render()
    {
    
        return view('livewire.transaksi.actions', [
            'services' => Service::when($this->search, function($service){
                $service->where('name', 'like', '%'.$this->search.'%')->orWhere('description', 'like', '%'.$this->search.'%')->orwhere('price', 'like', '%'.$this->search.'%');
            })->get()->groupBy('unit'),
            'customers' => Customer::pluck('name','id')
        ]);
    }
}

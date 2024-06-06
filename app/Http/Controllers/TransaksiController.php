<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Traits\HttpResponses;

class TransaksiController extends Controller
{
    use HttpResponses;

    public function getTransaksiByCustomerId($customerId)
    {
        $transaksi = Transaksi::where('customer_id', $customerId)->get();



        return $this->success($transaksi);
    }
}
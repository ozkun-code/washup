<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Traits\HttpResponses;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    use HttpResponses;

    public function getTransaksiByCustomerId($customerId)
    {
        $transaksi = Transaksi::where('customer_id', $customerId)->get();

        return $this->success($transaksi);
    }
    public function getTransaksiById($id)
    {
        $transaksi = Transaksi::where('id', $id)->get();

        return $this->success($transaksi);
    }
    public function getCompletedTransactions($customerId)
    {
        // Mengambil transaksi dengan status 'sudah diambil'
        $completedTransactions = Transaksi::where('customer_id', $customerId)
                                          ->where('status', 'sudah diambil')
                                          ->get();

        return $this->success($completedTransactions);
    }

    public function getOngoingTransactions($customerId)
    {
        $oneDayAgo = Carbon::now()->subDay();

        // Mengambil transaksi yang statusnya bukan 'sudah diambil' atau
        // transaksi dengan status 'sudah diambil' yang diperbarui dalam 24 jam terakhir
        $ongoingTransactions = Transaksi::where('customer_id', $customerId)
                                        ->where('status', '!=', 'sudah diambil')
                                        ->orWhere(function ($query) use ($oneDayAgo) {
                                            $query->where('status', 'sudah diambil')
                                                  ->where('updated_at', '>=', $oneDayAgo);
                                        })
                                        ->get();

        return $this->success($ongoingTransactions);
    }
}
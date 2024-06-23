<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Customer;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    use HttpResponses;

    private function checkAuth($customerId)
    {
        
        $authenticatedUser = Auth::user();
        dd($authenticatedUser);
        $authenticatedCustomerId = Customer::where('user_id', $authenticatedUser->id)->value('id');
        
        
        if ($authenticatedCustomerId != $customerId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function getTransaksiByCustomerId($customerId)
    {
        if ($response = $this->checkAuth($customerId)) return $response;
        return $this->success(Transaksi::where('customer_id', $customerId)->get());
    }

    public function getTransaksiById($id)
    {
        return $this->success(Transaksi::where('id', $id)->get());
    }

    public function getCompletedTransactions($customerId)
    {
        dd($this->checkAuth($customerId));
        if ($response = $this->checkAuth($customerId)) return $response;
        return $this->success(Transaksi::where('customer_id', $customerId)->where('status', 'sudah diambil')->get());
    }

    public function getOngoingTransactions($customerId)
    {
        if ($response = $this->checkAuth($customerId)) return $response;
        $oneDayAgo = Carbon::now()->subDay();
        $ongoingTransactions = Transaksi::where('customer_id', $customerId)
            ->where(function ($query) use ($oneDayAgo) {
                $query->where('status', '!=', 'sudah diambil')
                      ->orWhere('updated_at', '>=', $oneDayAgo);
            })->get();

        return $this->success($ongoingTransactions);
    }
}

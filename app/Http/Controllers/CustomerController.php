<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\Customer; // Asumsikan Anda memiliki model Customer

class CustomerController extends Controller
{
    use HttpResponses;
    public function getCustomer(Request $request)
    {
        $userId = $request->user()->id;
        // Mendapatkan data customer berdasarkan user_id
        $customer = Customer::where('user_id', $userId)->first();
        // Jika customer tidak ditemukan, kembalikan response error
        if (!$customer) {
            return $this->error('', 'Credentials do not match', 401);
        }

        // Jika customer ditemukan, kembalikan data customer
        return $this->success($customer);
    }
}
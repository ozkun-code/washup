<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\User; // Asumsikan Anda memiliki model User
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
    public function update(Request $request)
{
    $userId = $request->user()->id;
    $customer = Customer::where('user_id', $userId)->first();

    if (!$customer) {
        return $this->error('', 'Customer not found', 404);
    }

    $user = User::find($userId);
    if (!$user) {
        return $this->error('', 'User not found', 404);
    }

    $user->email = $request->input('email');
    $user->save();

    $customer->name = $request->input('name');
    $customer->contact = $request->input('contact');
    $customer->address = $request->input('address');
    $customer->save();

    return $this->success($customer);
}
}
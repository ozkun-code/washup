<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\Voucher;
use App\Models\ClaimedVoucher;
use App\Models\Customer;


class VoucherController extends Controller
{
    use HttpResponses;
    public function getAll()
    {
        $vouchers = Voucher::all();
        return $this->success($vouchers);

    }
 
    
 
    public function claim(Request $request, $voucherId)
    {
        $voucher = Voucher::find($voucherId);
        if (!$voucher) {
            return $this->error(null, 'Voucher not found', 404);
        }
        $userId = $request->user()->id;
    
        $customer = Customer::where('user_id', $userId)->first();
        if (!$customer) {
            return $this->error(null, 'Customer not found', 404);
        }
    
        if ($customer->points >= $voucher->points_required) {
            $customer->points -= $voucher->points_required;
            $customer->save();

            $claimedVoucher = ClaimedVoucher::create([
                'user_id' => $customer->user_id,
                'voucher_id' => $voucher->id,
                'claimed_at' => now(),
            ]);
    
            return $this->success($claimedVoucher);
        } else {
            return $this->error(null, 'Not enough points', 400);
        }
    }

}
    
?>
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimedVoucher extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'voucher_id', 'claimed_at', 'used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
?>
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
  
    protected $fillable = ['name', 'contact', 'user_id','address'];public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vouchers()
{
    return $this->hasMany(Voucher::class); // Ganti 'Voucher::class' dengan namespace yang benar
}
}

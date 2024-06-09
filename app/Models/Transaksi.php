<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;


    
    protected $fillable = [
        'discount',
        'customer_id',
        'description',
        'items',
        'price',
        'status',
        'created_at',
    ];
    public static $status = ['dibayar','dalam antrian', 'dicuci', 'disetrika', 'siap diambil', 'sudah diambil'];

    protected function casts() {
        return [
            'items' => 'array',
        ];
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function statusLogs()
    {
        return $this->hasMany('App\Models\StatusLog', 'transaksi_id');
    }
}

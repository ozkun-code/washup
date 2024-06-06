<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    
    use HasFactory;
    protected $fillable = ['transaksi_id', 'status', 'changed_at'];
    public function transaksi()
{
    return $this->belongsTo(Transaksi::class);
}
}

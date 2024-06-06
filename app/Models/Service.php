<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['id','name', 'photo', 'description', 'price', 'estimated_completion_time','unit'];


    public static $unit = ['kg','pcs'];

    

    public function getHargaAttribute()
    {
        return 'Rp. ' .  Number::format($this->price);
    }
    public function getFotoAttribute()
    {
        return $this->photo ? Storage::url($this->photo) : url('noimage.png');
    }

}

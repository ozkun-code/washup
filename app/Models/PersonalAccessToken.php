<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'personal_access_tokens';

    // Mass assignable attributes
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at',
    ];

    // Casts untuk atribut yang perlu diubah tipe datanya saat diambil dari database
    protected $casts = [
        'abilities' => 'array', // Misalnya, jika 'abilities' disimpan sebagai JSON
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke model tokenable (User atau model lain)
    public function tokenable()
    {
        return $this->morphTo();
    }
}
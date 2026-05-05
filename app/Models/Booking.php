<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'layanan',
        'tanggal',
        'jam',
        'whatsapp',
        'status'
    ];

    // ✅ relasi ke user (penting untuk future)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
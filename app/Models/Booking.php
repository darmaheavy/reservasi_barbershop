<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * Secara eksplisit diarahkan ke 'bookings' agar sinkron dengan database.
     */
    protected $table = 'bookings';

    /**
     * Atribut yang dapat diisi (mass assignable).
     */
    protected $fillable = [
        'user_id',
        'nama',
        'layanan',
        'tanggal',
        'jam',
        'whatsapp',
        'status'
    ];

    /**
     * Relasi ke User.
     * Menghubungkan setiap booking dengan akun pengguna yang memesan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
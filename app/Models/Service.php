<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // Nama tabel di Supabase
    protected $table = 'services';

    // Kolom-kolom yang ada di screenshot kamu
    protected $fillable = [
        'nama_layanan', // Sesuai screenshot
        'harga',
        'durasi_menit'  // Sesuai screenshot
    ];

    // Karena di screenshot tidak terlihat kolom created_at/updated_at di tabel services
    public $timestamps = false; 
}
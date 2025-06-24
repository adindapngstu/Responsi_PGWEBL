<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    // Nama tabel (opsional kalau nama model = nama tabel)
    protected $table = 'hotels';

    // Kolom yang bisa diisi (fillable) secara mass-assignment
    protected $fillable = [
        'name',
        'alamat',
        'kontak',
        'website',
        'rating_sum',
        'review_count',
        'rating',
        'review',
        'wkb_geometry'
    ];

    // Nonaktifkan timestamps (created_at dan updated_at) jika tidak dipakai
    public $timestamps = false;

    // Jika kamu pakai kolom geometri dan perlu konversi otomatis (opsional)
    protected $casts = [
        'wkb_geometry' => 'json',
    ];
    public function reviews()
    {
        return $this->hasMany(HotelReview::class, 'hotel_id', 'ogc_fid');
    }
}

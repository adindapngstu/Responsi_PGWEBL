<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelReview extends Model
{
    use HasFactory;

    protected $table = 'hotel_reviews';

    protected $fillable = [
        'hotel_id',
        'rating',
        'review',
        'foto', 
    ];

    /**
     * Relasi ke model Hotel
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'ogc_fid');
    }
}

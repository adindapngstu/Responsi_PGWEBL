<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function index()
    {
        $hotels = DB::table('hotels')
            ->join('hotel_reviews', 'hotels.ogc_fid', '=', 'hotel_reviews.hotel_id')
            ->select(
                'hotels.name',
                'hotel_reviews.rating',
                'hotel_reviews.review',
                'hotel_reviews.foto',
                'hotel_reviews.created_at'
            )
            ->orderBy('hotel_reviews.created_at', 'desc')
            ->get();

        return view('table', [
            'title' => 'Data Review Hotel',
            'hotels' => $hotels
        ]);
    }
}

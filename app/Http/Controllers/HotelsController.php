<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\HotelReview;

class HotelsController extends Controller
{
    public function getHotels()
    {
        try {
            $hotels = DB::table('hotels')
                ->select(
                    'ogc_fid',
                    'name',
                    'alamat',
                    'kontak',
                    'website',
                    'rating_sum',
                    'review_count',
                    'review',
                    DB::raw('ST_AsGeoJSON(wkb_geometry) as geometry')
                )
                ->get();

            $geojson = [
                "type" => "FeatureCollection",
                "features" => []
            ];

            foreach ($hotels as $hotel) {
                $geometry = json_decode($hotel->geometry);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::warning("Gagal decode geometry untuk hotel ID {$hotel->ogc_fid}");
                    continue;
                }

                $averageRating = $hotel->review_count > 0
                    ? round($hotel->rating_sum / $hotel->review_count, 2)
                    : 0;

                $geojson['features'][] = [
                    "type" => "Feature",
                    "geometry" => $geometry,
                    "properties" => [
                        "id" => $hotel->ogc_fid,
                        "name" => $hotel->name,
                        "Alamat" => $hotel->alamat,
                        "Kontak" => $hotel->kontak,
                        "website" => $hotel->website,
                        "average_rating" => $averageRating,
                        "total_reviews" => $hotel->review_count,
                        "user_review" => $hotel->review,
                    ]
                ];
            }

            return response()->json($geojson);
        } catch (\Exception $e) {
            Log::error("Error in getHotels(): " . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil data hotel'], 500);
        }
    }

    public function reviewFoto(Request $request, $id)
    {
        $userId = auth()->id() ?? 1;

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('foto_hotel', $filename, 'public');
            $path = 'storage/foto_hotel/' . $filename;
        }

        // Simpan atau update review
        DB::table('hotel_reviews')->updateOrInsert(
            ['hotel_id' => $id, 'user_id' => $userId],
            [
                'rating' => $request->rating,
                'review' => $request->review,
                'foto' => $path,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        // Update statistik rating hotel
        $stats = DB::table('hotel_reviews')
            ->where('hotel_id', $id)
            ->selectRaw('COUNT(*) as total, AVG(rating) as avg_rating')
            ->first();

        DB::table('hotels')
            ->where('ogc_fid', $id)
            ->update([
                'review_count' => $stats->total,
                'rating_sum' => $stats->avg_rating * $stats->total,
                'rating' => round($stats->avg_rating, 2),
                'review' => $request->review
            ]);

        return response()->json(['message' => 'Review dan foto berhasil disimpan']);
    }

    public function editReview(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        try {
            $hotel = DB::table('hotels')->where('ogc_fid', $id)->first();

            if (!$hotel || $hotel->review_count == 0) {
                return response()->json(['error' => 'Belum ada review yang bisa diubah'], 404);
            }

            $oldRating = $hotel->rating_sum / $hotel->review_count;
            $newSum = $hotel->rating_sum - $oldRating + $validated['rating'];
            $newAverage = round($newSum / $hotel->review_count, 2);

            DB::table('hotels')
                ->where('ogc_fid', $id)
                ->update([
                    'rating_sum' => $newSum,
                    'rating' => $newAverage,
                    'review' => $validated['review'],
                ]);

            return response()->json(['message' => 'Review berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengubah review'], 500);
        }
    }

    public function deleteReview($id)
    {
        try {
            $hotel = DB::table('hotels')->where('ogc_fid', $id)->first();

            if (!$hotel || $hotel->review_count == 0) {
                return response()->json(['error' => 'Tidak ada review untuk dihapus'], 404);
            }

            $lastRating = $hotel->rating_sum / $hotel->review_count;
            $newCount = $hotel->review_count - 1;
            $newSum = $hotel->rating_sum - $lastRating;
            $newAverage = $newCount > 0 ? round($newSum / $newCount, 2) : 0;

            DB::table('hotels')
                ->where('ogc_fid', $id)
                ->update([
                    'rating_sum' => $newSum,
                    'review_count' => $newCount,
                    'rating' => $newAverage,
                    'review' => null,
                ]);

            return response()->json(['message' => 'Review berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus review'], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $hotels = DB::select("
            SELECT ogc_fid, name, alamat, kontak, website, rating_sum, review_count, review,
                ST_AsGeoJSON(wkb_geometry) as geometry
            FROM hotels
            WHERE name ILIKE ?
        ", ['%' . $query . '%']);

        $geojson = [
            "type" => "FeatureCollection",
            "features" => []
        ];

        foreach ($hotels as $hotel) {
            $geometry = json_decode($hotel->geometry);

            if (json_last_error() !== JSON_ERROR_NONE || !$geometry) {
                Log::warning("Gagal decode geometry untuk hotel ID {$hotel->ogc_fid}");
                continue;
            }

            $averageRating = $hotel->review_count > 0
                ? round($hotel->rating_sum / $hotel->review_count, 2)
                : 0;

            $geojson['features'][] = [
                "type" => "Feature",
                "geometry" => $geometry,
                "properties" => [
                    "id" => $hotel->ogc_fid,
                    "name" => $hotel->name,
                    "Alamat" => $hotel->alamat,
                    "Kontak" => $hotel->kontak,
                    "website" => $hotel->website,
                    "average_rating" => $averageRating,
                    "total_reviews" => $hotel->review_count,
                    "user_review" => $hotel->review,
                ]
            ];
        }


        return response()->json($geojson);
    }
    public function carouselFoto()
    {
        $fotos = DB::table('hotel_reviews')
            ->whereNotNull('foto')
            ->pluck('foto');

        return view('home', compact('fotos'));
    }
}

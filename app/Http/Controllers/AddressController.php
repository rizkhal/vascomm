<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkerPresenceLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public function get(Request $request, Worker $worker)
    {
        $apiKey = config('gmap.api_key');

        $json = Http::get("https://maps.googleapis.com/maps/api/geocode/json?latlng={$request->lat},{$request->lng}&sensor=false&key={$apiKey}")->json();

        $body = $json['results'][1];

        $kecamatan = null;
        $kabupaten = null;
        $desa = null;
        $provinsi = null;

        foreach ($body['address_components'] as $component) {
            if (in_array('administrative_area_level_1', $component['types'])) {
                $provinsi = $component['long_name'];
            }

            if (in_array('administrative_area_level_2', $component['types'])) {
                $kabupaten = $component['long_name'];
            }

            if (in_array('administrative_area_level_3', $component['types'])) {
                $kecamatan = $component['long_name'];
            }

            if (in_array('administrative_area_level_4', $component['types'])) {
                $desa = $component['long_name'];
            }
        }

        return match (strtolower($worker->getRole())) {
            'kabupaten' => response()->json([
                'location' => $kabupaten,
            ]),
            'kecamatan' => response()->json([
                'location' => $kecamatan,
            ]),
            'kelurahan' => response()->json([
                'location' => $desa,
            ]),
            default => response()->json([
                'location' => null,
            ]),
        };
    }

    public function set(Request $request, Worker $worker)
    {
        $request->validate([
            'lat' => ['required'],
            'lng' => ['required'],
            'location_address' => ['required', Rule::unique('worker_presence_locations', 'location_address')->where('worker_id', $worker->id)],
        ]);

        return DB::transaction(function () use ($request, $worker) {
            $worker->worker_presence_locations()->create([
                'lat' => $request->lat,
                'lng' => $request->lng,
                'location_address' => $request->location_address,
            ]);

            return back()->success('Berhasil mengatur lokasi absensi');
        });
    }

    public function destroy(WorkerPresenceLocation $location)
    {
        return DB::transaction(function () use ($location) {
            $location->delete();

            return back()->success('Berhasil menghapus lokasi');
        });
    }
}

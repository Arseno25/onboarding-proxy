<?php

namespace App\Http\Controllers;

use App\Models\Digiflazz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Webhook extends Controller
{
    public function handle(Request $request)
    {
        $digiflazz = Digiflazz::all()->first();

        // Validasi request dari website lain
        $validated = $request->validate([
            'endpoint' => 'required|string',
            'data' => 'required|array',
        ]);

        // Kirim request ke Digiflazz
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($digiflazz->url . $validated['endpoint'], $validated['data']);

        // Return response ke website client
        return response()->json($response->json());
    }
}
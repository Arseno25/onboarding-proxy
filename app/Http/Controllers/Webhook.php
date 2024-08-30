<?php

namespace App\Http\Controllers;

use App\Models\Digiflazz;
use App\Models\RequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Webhook extends Controller
{
    public function handle(Request $request)
    {
        $digiflazz = Digiflazz::where('provider', $request->provider)->firstOrFail();

        $validated = $request->validate([
            'endpoint' => 'required|string',
            'data' => 'required|array',
        ]);

        RequestLog::create([
            'endpoint' => $validated['endpoint'],
            'data' => $validated['data'],
            'meta' => [
                'user_agent' => $request->header('User-Agent'),
                'ip_address' => $request->ip(),
            ],
        ]);

        $response = Http::post($digiflazz->url . $validated['endpoint'], $validated['data']);

        return response()->json($response->json() ?? []);
    }
}
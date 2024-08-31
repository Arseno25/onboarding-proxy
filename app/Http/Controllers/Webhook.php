<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\RequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Webhook extends Controller
{
    public function handle(Request $request)
    {
        try {
            $proxy = Service::where('provider', $request->provider)->firstOrFail();

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
                    'method' => $request->method(),
                ],
            ]);

            $response = Http::post($proxy->url . $validated['endpoint'], $validated['data']);

            return response()->json($response->json() ?? []);
        } catch (\Exception $e) {
            \Log::error('Error handling webhook: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e,
            ]);

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }
}
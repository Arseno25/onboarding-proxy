<?php

namespace App\Services\Webhook;

use App\Models\Service;
use App\Models\RequestLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WebhookService
{
    public function handle(Request $request)
    {
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

        return $response->json() ?? [];
    }
}
<?php

namespace App\Http\Controllers;

use App\Services\Webhook\WebhookService;
use Illuminate\Http\Request;

class Webhook extends Controller
{
    protected WebhookService $webhookService;

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    public function handle(Request $request)
    {
        try {
            $response = $this->webhookService->handle($request);
            return response()->json($response);
        } catch (\Exception $e) {
            \Log::error('Error handling webhook: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e,
            ]);

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }
}
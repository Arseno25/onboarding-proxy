<?php

use App\Http\Controllers\Webhook;
use App\Models\RequestLog;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

it('handles a valid webhook request', function () {
    $service = Service::factory()->create([
        'provider' => 'test_provider',
        'url' => 'https://example.com/api',
    ]);

    $request = Request::create('/webhook', 'POST', [
        'provider' => 'test_provider',
        'endpoint' => '/test-endpoint',
        'data' => ['key' => 'value'],
    ]);

    Http::fake([
        'https://example.com/api/test-endpoint' => Http::response(['success' => true], 200),
    ]);

    $response = (new Webhook())->handle($request);

    $response->setStatusCode(200);
    $response->setJson(json_encode(['success' => true]));

    expect($response->getStatusCode())->toBe(200);

    $log = RequestLog::first();
    expect($log->endpoint)->toBe('/test-endpoint')
        ->and($log->data)->toBe(['key' => 'value']);
});

it('handles a request with missing data and returns a validation error', function () {
    $request = Request::create('/webhook', 'POST', [
        'provider' => 'test_provider',
        'endpoint' => null,
        'data' => null,
    ]);

    $response = (new Webhook())->handle($request);

    expect($response->getStatusCode())->toBe(500)
        ->and($response->getData(true))->toMatchArray([
            'error' => 'An error occurred while processing the request.',
        ]);
});

it('handles an exception and logs the error', function () {
    $request = Request::create('/webhook', 'POST', [
        'provider' => 'non_existing_provider',
        'endpoint' => '/test-endpoint',
        'data' => ['key' => 'value'],
    ]);

    Log::shouldReceive('error')
        ->once()
        ->withArgs(function ($message, $context) {
            return str_contains($message, 'Error handling webhook');
        });

    $response = (new Webhook())->handle($request);

    $response->setStatusCode(500);
    $response->setJson(json_encode(['error' => 'An error occurred while processing the request.']));
});
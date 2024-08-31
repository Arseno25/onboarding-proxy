<?php

use App\Http\Controllers\Webhook;
use App\Services\Webhook\WebhookService;
use App\Models\RequestLog;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->webhookService = Mockery::mock(WebhookService::class);
    $this->webhookController = new Webhook($this->webhookService);
});

it('handles a valid webhook request', function () {
    $service = Service::factory()->create([
        'provider' => 'test_provider',
        'url' => 'https://example.com/api',
    ]);

    $request = Request::create('/webhook', 'POST', [
        'provider' => 'test_provider',
        'endpoint' => '/test-endpoint',
        'data' => ['key' => 'value'],
        'meta' => [
            'user_agent' => 'Symfony',
            'ip_address' => '0.0.0.0',
            'method' => 'POST',
        ],
    ]);

    Http::fake([
        'https://example.com/api/test-endpoint' => Http::response(['success' => true], 200),
    ]);

    $this->webhookService->shouldReceive('handle')
        ->once()
        ->with($request)
        ->andReturn(['success' => true]);

    $response = $this->webhookController->handle($request);

    expect($response->getStatusCode())->toBe(200)
        ->and($response->getData(true))->toMatchArray(['success' => true]);

    $log = RequestLog::factory()->create([
        'endpoint' => '/test-endpoint',
        'data' => ['key' => 'value'],
        'meta' => [
            'user_agent' => 'Symfony',
            'ip_address' => '0.0.0.0',
            'method' => 'POST',
        ],
    ]);

    expect($log)->not->toBeNull()
        ->and($log->endpoint)->toBe('/test-endpoint')
        ->and($log->data)->toBe(['key' => 'value']);
});

it('handles a request with missing data and returns a validation error', function () {
    $request = Request::create('/webhook', 'POST', [
        'provider' => 'test_provider',
        'endpoint' => null,
        'data' => null,
    ]);

    $this->webhookService->shouldReceive('handle')
        ->once()
        ->with($request)
        ->andThrow(new \Exception('Validation error'));

    $response = $this->webhookController->handle($request);

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

    $this->webhookService->shouldReceive('handle')
        ->once()
        ->with($request)
        ->andThrow(new \Exception('Service not found'));

    $response = $this->webhookController->handle($request);

    expect($response->getStatusCode())->toBe(500)
        ->and($response->getData(true))->toMatchArray([
            'error' => 'An error occurred while processing the request.',
        ]);
});
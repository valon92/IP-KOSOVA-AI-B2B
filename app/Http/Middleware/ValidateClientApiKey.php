<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateClientApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-Api-Key')
            ?? $request->input('api_key')
            ?? $request->query('api_key');

        if (! $apiKey) {
            return response()->json(['message' => 'API key is required.'], 401);
        }

        $client = Client::query()
            ->where('api_key', $apiKey)
            ->where('is_active', true)
            ->first();

        if (! $client) {
            return response()->json(['message' => 'Invalid or inactive API key.'], 401);
        }

        $request->attributes->set('client', $client);

        return $next($request);
    }
}

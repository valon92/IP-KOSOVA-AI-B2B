<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClientAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $client = Client::query()
            ->where('email', $credentials['email'])
            ->where('is_active', true)
            ->first();

        if (! $client || ! $client->password || ! Auth::guard('client')->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => ['Email ose fjalëkalimi është i gabuar.'],
            ]);
        }

        $request->session()->regenerate();

        /** @var Client $authenticated */
        $authenticated = Auth::guard('client')->user();

        return response()->json([
            'message' => 'Login i suksesshëm.',
            'client' => $this->clientPayload($authenticated),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'U çkyçët.']);
    }

    public function me(Request $request): JsonResponse
    {
        /** @var Client $client */
        $client = Auth::guard('client')->user();

        return response()->json([
            'data' => $this->clientPayload($client),
        ]);
    }

    private function clientPayload(Client $client): array
    {
        return [
            'id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
            'domain' => $client->domain,
        ];
    }
}

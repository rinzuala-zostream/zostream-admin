<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiProxyController extends Controller
{
    public function proxyRequest(Request $request)
    {

        if ($request->getMethod() == 'OPTIONS') {
            return response()->json([], 200);
        }

        // API URL and API Key
        $endpoint = $request->query('endpoint'); // e.g., movies, get-subscription, etc.
        if (!$endpoint) {
            return response()->json(['error' => 'Missing endpoint'], 400);
        }

        // Build the full backend API URL
        $apiUrl = "http://192.168.1.38:8000/api/{$endpoint}";
        $apiKey = '12345qwerty';
        // Check for GET or POST request and forward accordingly
        $method = $request->method();
        $headers = [
            'X-API-KEY' => $apiKey,
            'Content-Type' => 'application/json',
        ];

        if ($method === 'POST') {
            // Forward POST request with body
            $response = Http::withHeaders($headers)
                            ->post($apiUrl, $request->all()); // Forward the request body
        } else {
            // Forward GET request with query parameters
            $response = Http::withHeaders($headers)
                            ->get($apiUrl, $request->query()); // Forward the query params
        }

        // Return the response from the API backend
        return response()->json($response->json(), $response->status());
    }
}
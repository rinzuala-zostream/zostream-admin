<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DecryptController extends Controller
{
    /**
     * Handle the decryption of the movie URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrypt(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'encrypted_url' => 'required|string',
            ]);

            $encryptedUrl = $validated['encrypted_url'];
            $shaKey = 'd4c6198dabafb243b0d043a3c33a9fe171f81605158c267c7dfe5f66df29559a';

            // Generate the decryption key (256-bit)
            $decryptionKey = hash('sha256', $shaKey, true);

            // Decode the base64 encrypted message
            $data = base64_decode($encryptedUrl);
            if ($data === false || strlen($data) <= 16) {
                throw new \Exception("Invalid encrypted data.");
            }

            // Extract IV (first 16 bytes) and cipher text
            $iv = substr($data, 0, 16);
            $cipherText = substr($data, 16);

            // Decrypt the cipher text
            $decryptedMessage = openssl_decrypt(
                $cipherText,
                'aes-256-cbc',
                $decryptionKey,
                OPENSSL_RAW_DATA,
                $iv
            );

            // Check if decryption was successful
            if ($decryptedMessage === false) {
                throw new \Exception("Decryption failed.");
            }

            // Remove any unwanted characters
            $decryptedMessage = trim($decryptedMessage);

            // Return the decrypted URL
            return response()->json([
                'status' => '103',
                'url' => $decryptedMessage,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Decryption validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'status' => '400',
                'error' => 'Validation error',
                'details' => $e->errors(),
            ], 400);
        } catch (\Exception $e) {
            Log::error('Decryption error', ['message' => $e->getMessage()]);
            return response()->json([
                'status' => '500',
                'error' => 'Decryption error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

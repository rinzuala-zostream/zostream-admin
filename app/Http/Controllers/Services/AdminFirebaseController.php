<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\UserNotFound;

class AdminFirebaseController extends Controller
{
    public function deleteUser(Request $request)
    {
        // (Optional) Simple protection using an API key header.
        // if ($request->header('X-Api-Key') !== config('app.api_key')) {
        //     return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        // }

        // Validate inputs
        $data = $request->validate([
            'uid'   => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
        ]);

        $uid   = trim((string)($data['uid'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));

        if ($uid === '' && $email === '') {
            throw ValidationException::withMessages([
                'uid' => 'UID or email is required.',
                'email' => 'UID or email is required.',
            ]);
        }

        // Build Auth client explicitly (avoids container DI issues)
        $auth = (new Factory())
            ->withServiceAccount(env('FIREBASE_CREDENTIALS'))
            ->withProjectId(env('FIREBASE_PROJECT_ID'))
            ->createAuth();

        try {
            // If UID missing but email provided, resolve UID
            if ($uid === '' && $email !== '') {
                try {
                    $record = $auth->getUserByEmail($email);
                    $uid = $record->uid;
                } catch (UserNotFound $e) {
                    // Idempotent delete: user not found -> 404 (or 200 if you prefer “idempotent success”)
                    return response()->json(['status' => 'error', 'message' => 'User not found for email'], 404);
                }
            }

            $auth->deleteUser($uid);

            Log::info('[Admin] Deleted Firebase user', ['uid' => $uid, 'email' => $email ?: null]);

            return response()->json(['status' => 'success', 'message' => 'Deleted from Firebase Auth']);
        } catch (UserNotFound $e) {
            // Deleting by UID that doesn’t exist
            return response()->json(['status' => 'error', 'message' => 'User not found for UID'], 404);
        } catch (\Throwable $e) {
            Log::error('Firebase delete failed', [
                'error' => $e->getMessage(),
                'uid'   => $uid,
                'email' => $email ?: null,
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}

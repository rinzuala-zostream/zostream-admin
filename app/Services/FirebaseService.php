<?php

namespace App\Services;

use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth; // ✅ this is the correct one

class FirebaseService
{
    protected Auth $auth;

    public function __construct()
    {
        $path = config('firebase.credentials.file');

        if (!file_exists($path)) {
            throw new \RuntimeException("Firebase credentials file not found at: $path");
        }

        $this->auth = (new Factory)
            ->withServiceAccount($path)
            ->createAuth();
    }

    public function getUserStats(): array
{
    $total = $today = $yesterday = 0;

    $now = Carbon::now('UTC');
    $startToday = $now->copy()->startOfDay();
    $startYesterday = $now->copy()->subDay()->startOfDay();
    $endYesterday = $now->copy()->subDay()->endOfDay();

    $page = null;

do {
    $result = $this->auth->listUsers($page, 1000); // ✅ Corrected order

    foreach ($result as $user) {
        $total++;

        $createdAt = Carbon::parse($user->metadata->createdAt)->setTimezone('UTC');

        if ($createdAt->greaterThanOrEqualTo($startToday)) {
            $today++;
        } elseif ($createdAt->between($startYesterday, $endYesterday)) {
            $yesterday++;
        }
    }

    $page = $result->nextPageToken();
} while ($page);

}
}


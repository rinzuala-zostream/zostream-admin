<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class FirebaseController extends Controller
{
    public function getStats(FirebaseService $firebase)
    {
        return response()->json($firebase->getUserStats());
    }
}

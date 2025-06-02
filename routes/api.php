<?php

use App\Http\Controllers\Api\ApiProxyController;
use Illuminate\Support\Facades\Route;

Route::post('/proxy', [ApiProxyController::class, 'proxyRequest'])->name('proxy.post');
Route::get('/proxy', [ApiProxyController::class, 'proxyRequest'])->name('proxy.get');
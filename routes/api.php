<?php

use App\Http\Controllers\Api\ApiProxyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DecryptController;

Route::post('/proxy', [ApiProxyController::class, 'proxyRequest'])->name('proxy.post');
Route::get('/proxy', [ApiProxyController::class, 'proxyRequest'])->name('proxy.get');
Route::put('/proxy', [ApiProxyController::class, 'proxyRequest'])->name('proxy.put');
Route::post('/decrypt', [DecryptController::class, 'decrypt'])->name('decrypt');

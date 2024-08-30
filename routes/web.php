<?php

use Illuminate\Support\Facades\Route;

Route::post('/proxy',[ \App\Http\Controllers\Webhook::class, 'handle'])->name('proxy');

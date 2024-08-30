<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/proxy',[ \App\Http\Controllers\Webhook::class, 'handle'])->name('proxy');

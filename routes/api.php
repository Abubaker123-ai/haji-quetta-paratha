<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::post('/contact', [ContactController::class, 'apiStore']);

Route::get('/contacts', [ContactController::class, 'apiIndex']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InitiativeController;

Route::apiResource('initiatives', InitiativeController::class);

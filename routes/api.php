<?php

use App\Http\Controllers\PaymentController;
use App\Http\Middleware\Gateways\Gateway;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware([Gateway::class])
    ->controller(PaymentController::class)
    ->group(static function (): void {
        Route::post('create', 'new');
    })
;

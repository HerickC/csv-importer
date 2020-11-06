<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ImportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('clients',           [ClientController::class, 'getClients']);
Route::get('teste/{id}',        [ClientController::class, 'testGmap']);
Route::delete('clients/{id}',   [ClientController::class, 'deleteClient']);

Route::post('/import',          [ImportController::class, 'importClients']);

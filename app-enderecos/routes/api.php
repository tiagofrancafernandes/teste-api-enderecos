<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


## CEP

Route::get('address/search/{term?}',   [AddressController::class, 'search'])->name('search');
Route::get('address/cep/{cep}',        [AddressController::class, 'addressByCep'])->name('address_by_cep');
Route::resource('address',             AddressController::class);

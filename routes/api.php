<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// CREATE
// {
//     "name": "Nome da loja",
//     "postal_code": "01001000",
//     "street_number": "123",
//     "complement": "Complemento opcional"
// }
Route::post('/stores', [ApiController::class, 'store']);
// READ
Route::get('/stores', [ApiController::class, 'show']);
// UPDATE
Route::get('/stores/{id}', [ApiController::class, 'update']);
// DELETE

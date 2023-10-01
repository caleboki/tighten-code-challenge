<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Version 1 of the API
Route::prefix('v1')->namespace('API\V1')->group(function () {

    // Capybara routes
    Route::prefix('capybaras')->group(function () {
        // List all capybaras
        Route::get('/', 'CapybaraController@index')->name('v1.capybaras.index');

        // Add a new capybara
        Route::post('/', 'CapybaraController@store')->name('v1.capybaras.store');

        // Get details of a specific capybara
        Route::get('{capybara}', 'CapybaraController@show')->name('v1.capybaras.show');

        // Nested routes for observations related to a specific capybara
        Route::prefix('{capybara}/observations')->group(function () {
            // Submit an observation for a specific capybara
            Route::post('/', 'ObservationController@store')->name('v1.capybaras.observations.store');

            // List all observations for a specific capybara
            Route::get('/', 'ObservationController@index')->name('v1.capybaras.observations.index');

            // Get details of a specific observation for a capybara
            Route::get('{observation}', 'ObservationController@show')->name('v1.capybaras.observations.show');
        });
    });
});

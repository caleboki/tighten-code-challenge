<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CapybaraController;
use App\Http\Controllers\API\V1\ObservationController;

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
        /**
         * @OA\Get(
         *     path="/v1/capybaras",
         *     summary="List all capybaras",
         *     tags={"Capybaras"},
         *     @OA\Response(
         *         response=200,
         *         description="Successful operation",
         *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Capybara"))
         *     )
         * )
         */
        Route::get('/', [CapybaraController::class, 'index'])->name('v1.capybaras.index');

        // Add a new capybara
        /**
         * @OA\Post(
         *     path="/v1/capybaras",
         *     summary="Add a new capybara",
         *     tags={"Capybaras"},
         *     @OA\RequestBody(
         *         description="Capybara data",
         *         required=true,
         *         @OA\JsonContent(ref="#/components/schemas/Capybara")
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Capybara created successfully",
         *         @OA\JsonContent(ref="#/components/schemas/Capybara")
         *     )
         * )
         */
        Route::post('/', [CapybaraController::class, 'store'])->name('v1.capybaras.store');

        // Get details of a specific capybara
        Route::get('{capybara}', [CapybaraController::class, 'show'])->name('v1.capybaras.show');

        // Update a specific capybara
        Route::put('{capybara}', [CapybaraController::class, 'update'])->name('v1.capybaras.update');

        // Delete a specific capybara
        Route::delete('{capybara}', [CapybaraController::class, 'destroy'])->name('v1.capybaras.destroy');

        // Nested routes for observations related to a specific capybara
        Route::prefix('{capybara}/observations')->group(function () {
            // Submit an observation for a specific capybara
            Route::post('/', [ObservationController::class, 'store'])->name('v1.capybaras.observations.store');

            // List all observations for a specific capybara
            Route::get('/', [ObservationController::class, 'index'])->name('v1.capybaras.observations.index');
        });
    });

    /**
     * @OA\Get(
     *     path="/v1/observations",
     *     summary="List all observations",
     *     tags={"Observations"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Observation"))
     *     )
     * )
     */
    Route::get('/observations', [ObservationController::class, 'allObservations'])->name('v1.observations.all');

});

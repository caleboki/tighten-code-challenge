<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ObservationResource;
use App\Models\Capybara;
use App\Models\Observation;

class ObservationController extends Controller
{
    public function index(Capybara $capybara)
    {
        $observations = $capybara->observations;
        return ObservationResource::collection($observations);
    }

    public function show(Observation $observation)
    {
        return new ObservationResource($observation);
    }

    public function store(Request $request, Capybara $capybara)
    {
        $validatedData = $request->validate([
            'capybara_id' => 'required|exists:capybaras,id',
            'date' => 'required|date',
            'city' => 'required|in:Chicago,Atlanta,New York,Houston,San Francisco',
            'hat' => 'boolean',
        ]);

        $observation = new Observation($validatedData);
        $capybara->observations()->save($observation);

        return new ObservationResource($observation);
    }

    public function allObservations()
    {
        $observations = Observation::all();
        return ObservationResource::collection($observations);
    }

}

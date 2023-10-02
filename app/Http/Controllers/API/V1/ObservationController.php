<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ObservationResource;
use App\Models\Capybara;
use App\Models\Observation;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
        // Convert the incoming city request value to lowercase
        $request->merge(['city' => strtolower($request->city)]);

        $validatedData = $request->validate([
            'date' => [
                'required',
                'date',
                Rule::unique('observations')->where(function ($query) use ($request, $capybara) {
                    return $query->where('capybara_id', $capybara->id)
                                ->where('city', $request->city)
                                ->where('date', $request->date);
                }),
            ],
            'city' => 'required|in:chicago,atlanta,new york,houston,san francisco',
            'hat' => 'boolean',
        ]);

        // Convert the city attribute to its proper case before saving
        $validatedData['city'] = Str::title($validatedData['city']);

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

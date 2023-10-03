<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ObservationResource;
use App\Http\Resources\ObservationResourceCollection;
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

        $messages = [
            'date.required' => 'The observation date is required.',
            'date.date' => 'Please provide a valid date for the observation.',
            'date.unique' => 'An observation for this capybara in the specified city and date already exists.',
            'city.required' => 'The city of observation is required.',
            'city.in' => 'Please select a valid city from the provided options.',
            'hat.boolean' => 'The hat status should be either true (wearing a hat) or false (not wearing a hat).'
        ];

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
        ], $messages);

        // Convert the city attribute to its proper case before saving
        $validatedData['city'] = Str::title($validatedData['city']);

        $observation = new Observation($validatedData);
        $capybara->observations()->save($observation);

        return new ObservationResource($observation);
    }


    public function allObservations()
    {
        $observations = Observation::orderBy('created_at', 'desc')->paginate(10);
        return new ObservationResourceCollection($observations);
    }

}

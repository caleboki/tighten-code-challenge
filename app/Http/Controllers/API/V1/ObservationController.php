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
    /**
     * @OA\Get(
     *     path="/api/v1/capybaras/{capybaraId}/observations",
     *     summary="Get a list of observations for a specific capybara",
     *     @OA\Parameter(
     *         name="capybaraId",
     *         in="path",
     *         required=true,
     *         description="ID of the capybara to retrieve observations for",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of observations for the capybara",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Observation"))
     *     )
     * )
     */
    public function index(Capybara $capybara)
    {
        $observations = $capybara->observations;
        return ObservationResource::collection($observations);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/capybaras/{capybaraId}/observations",
     *     summary="Submit a new observation for a specific capybara",
     *     @OA\Parameter(
     *         name="capybaraId",
     *         in="path",
     *         required=true,
     *         description="ID of the capybara to submit an observation for",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Observation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Observation submitted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Observation")
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/v1/observations",
     *     summary="Get a list of all observations",
     *     @OA\Response(
     *         response=200,
     *         description="List of observations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Observation")
     *         )
     *     )
     * )
     */
    public function allObservations()
    {
        $observations = Observation::orderBy('created_at', 'desc')->paginate(10);
        return new ObservationResourceCollection($observations);
    }

}

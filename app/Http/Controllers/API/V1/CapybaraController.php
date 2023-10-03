<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Capybara;
use App\Http\Resources\CapybaraResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CapybaraController extends Controller
{
    /**
     * Display a listing of the capybaras.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/api/v1/capybaras",
     *     summary="Get a list of all capybaras",
     *     @OA\Response(
     *         response=200,
     *         description="List of capybaras",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Capybara"))
     *     )
     * )
     */

    public function index()
    {
        $capybaras = Capybara::all();
        return CapybaraResource::collection($capybaras);
    }

    /**
     * Store a newly created capybara in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Post(
     *     path="/api/v1/capybaras",
     *     summary="Create a new capybara",
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Capybara")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Capybara created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Capybara")
     *     )
     * )
     */

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|unique:capybaras',
            'color' => 'required',
            'size' => 'required',
        ]);

        $capybara = Capybara::create($data);

        return new CapybaraResource($capybara);
    }

    /**
     * Display the specified capybara.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */

    /**
     * @OA\Get(
     *     path="/api/v1/capybaras/{capybaraId}",
     *     summary="Get details of a specific capybara",
     *     @OA\Parameter(
     *         name="capybaraId",
     *         in="path",
     *         required=true,
     *         description="ID of the capybara to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the capybara",
     *         @OA\JsonContent(ref="#/components/schemas/Capybara")
     *     )
     * )
     */
    public function show($id)
    {
        $capybara = Capybara::findOrFail($id);
        return new CapybaraResource($capybara);
    }

    /**
     * Update the specified capybara in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/v1/capybaras/{capybaraId}",
     *     summary="Update details of a specific capybara",
     *     @OA\Parameter(
     *         name="capybaraId",
     *         in="path",
     *         required=true,
     *         description="ID of the capybara to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Capybara")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Capybara updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Capybara")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $capybara = Capybara::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|unique:capybaras,name,' . $capybara->id,
            'color' => 'required',
            'size' => 'required',
        ]);

        $capybara->update($data);

        return new CapybaraResource($capybara);
    }

    /**
     * Remove the specified capybara from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/api/v1/capybaras/{capybaraId}",
     *     summary="Delete a specific capybara",
     *     @OA\Parameter(
     *         name="capybaraId",
     *         in="path",
     *         required=true,
     *         description="ID of the capybara to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Capybara deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Capybara deleted successfully")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $capybara = Capybara::findOrFail($id);
        $capybara->delete();

        return response()->json(['message' => 'Capybara deleted successfully'], 200);
    }



}

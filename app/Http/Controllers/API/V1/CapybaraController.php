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
    public function destroy($id)
    {
        $capybara = Capybara::findOrFail($id);
        $capybara->delete();

        return response()->json(['message' => 'Capybara deleted successfully'], 200);
    }



}

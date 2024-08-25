<?php

namespace App\Http\Controllers;

use App\Http\Resources\Voyage\VoyageCollection;
use App\Http\Resources\Voyage\VoyageResource;
use App\Models\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoyageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $voyages = Voyage::all();
        if (is_null($voyages)) {
            return response()->json('No voyages found', 404);
        }
        return response()->json(new VoyageCollection($voyages));
    }

    public function indexPaginate()
    {
        $voyages = Voyage::all();
        if (is_null($voyages)) {
            return response()->json('No voyages found', 404);
        }
        $voyages = Voyage::paginate(5);
        return response()->json(new VoyageCollection($voyages));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string|max:255',
            'arrival' => 'required|date|after:now',
            'departure' => 'required|date|after:arrival',
            'transportation' => 'required|string|max:255',
            'total_cost' => 'required|integer|between:0,0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $voyage = Voyage::create([
            'destination' => $request->destination,
            'arrival' => $request->arrival,
            'departure' => $request->departure,
            'transportation' => $request->transportation,
            'total_cost' => $request->total_cost,
        ]);

        return response()->json([
            'Voyage inserted' => new VoyageResource($voyage)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function show($voyage_id)
    {
        $voyage = Voyage::find($voyage_id);
        if (is_null($voyage)) {
            return response()->json('Voyage not found', 404);
        }
        return response()->json(new VoyageResource($voyage));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function edit(Voyage $voyage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voyage $voyage)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required|string|max:255',
            'arrival' => 'required|date|after:now',
            'departure' => 'required|date|after:arrival',
            'transportation' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $voyage->destination = $request->destination;
        $voyage->arrival = $request->arrival;
        $voyage->departure = $request->departure;
        $voyage->transportation = $request->transportation;

        $voyage->save();

        return response()->json([
            'Voyage updated' => new VoyageResource($voyage)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voyage $voyage)
    {
        $voyage->delete();
        return response()->json('Voyage removed');
    }
}

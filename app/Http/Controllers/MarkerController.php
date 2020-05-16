<?php

namespace App\Http\Controllers;

use App\Marker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Marker::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        // create object
        $infoMessage = (Object) [];

        // checking if this marker was created earlier
        $validateMarker = DB::table('markers')
            ->where(['owner_id' => $request->owner_id, 'lat' => $request->lat, 'lng' => $request->lng])
            ->first();

        // if there is no markers like that
        if (!isset($validateMarker)) {
            $marker = new Marker;

            $marker->owner_id = $request->owner_id;
            $marker->lat = $request->lat;
            $marker->lng = $request->lng;

            if ($marker->save()) {
                $infoMessage->message = 'Marker successfully created';
                return response()->json($infoMessage);
            } else {
                return response()->view('errors.500', [], 500);
            }
        } else {
            $infoMessage->message = 'This marker have already been created by you';
            return response()->json($infoMessage);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marker  $marker
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Marker $marker)
    {
//        return response()->json(DB::table('markers')->where('id', $marker)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marker  $marker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marker $marker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marker  $marker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marker $marker)
    {
        Marker::find($marker)->delete();

        return 204;
    }
}

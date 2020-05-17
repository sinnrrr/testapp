<?php

namespace App\Http\Controllers;

use App\Marker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Marker::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // create object
        $infoMessage = (Object) [];

        // checking if this marker was created earlier
        $validateMarker = DB::table('markers')
            ->where([
                    'owner_id' => $request->owner_id,
                    'lat' => $request->lat,
                    'lng' => $request->lng
            ])->first();

        // if there is no markers like that
        if (!isset($validateMarker)) {
            $marker = new Marker();

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
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(Marker::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $marker = Marker::findOrFail($id);

        $marker->lat = $request->lat;
        $marker->lng = $request->lng;

        $marker->save();

        return response()->json((Object) ['message' => 'Marker successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        Marker::findOrFail($id)->delete();

        return response()->json((Object) ['message' => 'Marker successfully deleted']);
    }
}

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
        $markers = Marker::paginate(10);
        $markers->withPath('/');

        return response()->json($markers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
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
            $marker->title = $request->title;
            $marker->description = $request->description;

            if ($marker->save()) {
                $marker->message = 'Marker successfully created';

                return response()->json($marker);
            }
        } else {
            return response()->json((object)['message' => 'This marker has already been created by you'], 418);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
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
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $marker = Marker::findOrFail($id);

        $marker->title = $request->title;
        $marker->description = $request->description;

        if ($marker->save()) {
            $marker->message = "Marker ID {$id} successfully updated";

            return response()->json($marker);
        }
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

        return response()->json((object)['message' => "Marker ID {$id} successfully deleted"]);
    }
}

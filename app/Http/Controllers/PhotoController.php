<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Photo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $photo = new Photo();

        $photo->owner_id = $request->owner_id;
        $photo->marker_id = $request->marker_id;

        if ($request->hasFile('content')) {
            $photo->content = $request->file('content')->store('uploads', 'public');
        }

        if ($photo->save()) {
            $photo->message = 'Photo successfully uploaded';

            return response()->json($photo);
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
        return response()->json(Photo::findOrFail($id));
    }


    /**
     * Update the specified resource in storage.
     * Not sure if this should be in app.
     *
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        if ($request->hasFile('photos')) {
            $photo->content = $request->file('content')->store('uploads', 'public');
        }

        if ($photo->save()) {
            $photo->message = "Photo ID {$id} successfully updated";

            return response()->json($photo);
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
        Photo::findOrFail($id)->delete();

        return response()->json((Object) ['message' => "Photo ID {$id} successfully deleted"]);
    }
}

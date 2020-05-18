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
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $photo = new Photo();

        $photo->owner_id = $request->owner_id;
        $photo->marker_id = $request->marker_id;

        if ($request->hasFile('content')) {
            $photo->content = $request->file('content')->store('uploads', 'public');
        }

        $photo->save();

        return response()->json((Object) ['message' => 'Photo successfully created']);
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
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        if ($request->hasFile('photos')) {
            $photo->content = Storage::disk('public')->putFile('uploads', $request->file('photos'));
        }

        $photo->save();

        return response()->json((Object) ['message' => "Photo ID {$id} successfully updated"]);
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

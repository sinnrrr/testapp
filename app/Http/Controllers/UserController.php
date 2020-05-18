<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    /**
     * Display all markers, that belong to this user
     *
     * @param $id
     * @return JsonResponse
     */
    public function markers($id) {
        return response()->json(\App\Marker::where('owner_id', $id)->get());
    }

    /**
     * Display all comments, that belong to this user
     *
     * @param $id
     * @return JsonResponse
     */
    public function comments($id) {
        return response()->json(\App\Comment::where('owner_id', $id)->get());
    }

    /**
     * Display all photos, that belong to this user
     *
     * @param $id
     * @return JsonResponse
     */
    public function photos($id) {
        return response()->json(\App\Photo::where('owner_id', $id)->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json((Object) ['message' => "User ID {$id} successfully deleted"]);
    }
}

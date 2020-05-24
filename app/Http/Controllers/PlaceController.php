<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param $id
     * @return Renderable
     */
    public function index($id)
    {
        $markerData = \App\Marker::findOrFail($id);
        $userData = \App\User::findOrFail($markerData->owner_id);
        $photoData = \App\Photo::where('marker_id', $id)->get();
        $commentData = \App\Comment::where('marker_id', $id)->orderBy('created_at', 'desc')->get();

        $commentUserIDs = [];
        $commentUserData = [];
        $commentUserNameData = [];

        // process of getting all IDs related to comments
        // in order to make only one query, where we are getting user names
        // by the range of IDs
        if (!empty($commentData)) {
            foreach ($commentData as $comment) {
                array_push($commentUserIDs, $comment->owner_id);
            }
        }

        // checking if array has more than one ID
        if (!empty($commentUserIDs)) {
            $commentUserNameData = DB::table('users')
                ->select('id', 'name')
                ->whereIn('id', $commentUserIDs)
                ->get();

            // refactoring array
            foreach ($commentUserNameData as $data) {
                $commentUserData[$data->id] = $data->name;
            }
        }

        return view('place', [
            'markerData' => $markerData,
            'userData' => $userData,
            'photoData' => $photoData,
            'commentData' => $commentData,
            'commentUserData' => $commentUserData,
            'checkAuth' => !Auth::check(),
            'authID' => Auth::id(),
            'authName' => Auth::user()->name ?? 'Unknown'
        ]);
    }
}

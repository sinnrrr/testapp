<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Comment::all());
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

        // checking if this comment was created earlier
        $validateComments = DB::table('comments')
            ->where([
                'owner_id' => $request->owner_id,
                'marker_id' => $request->marker_id,
                'body' => $request->body
            ])->first();

        // if there is no comments like that
        if (!isset($validateComments)) {
            $comment = new Comment();

            $comment->owner_id = $request->owner_id;
            $comment->marker_id = $request->marker_id;
            $comment->body = $request->body;

            if ($comment->save()) {
                $infoMessage->message = 'Comment successfully created';
                return response()->json($infoMessage);
            } else {
                return response()->view('errors.500', [], 500);
            }
        } else {
            $infoMessage->message = 'This comment have already been created by you';
            return response()->json($infoMessage);
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
        return response()->json(Comment::findOrFail($id));
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
        $comment = Comment::findOrFail($id);

        $comment->body = $request->body;

        $comment->save();

        return response()->json((Object) ['message' => 'Comment successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();

        return response()->json((Object) ['message' => 'Comment successfully destroyed']);
    }
}

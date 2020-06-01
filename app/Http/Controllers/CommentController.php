<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Comment as CommentResource;

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
                $comment->message = 'Comment successfully created';
                return response()->json(new CommentResource($comment));
            } else {
                abort(500);
            }
        } else {
            return response()->json((object)['message' => 'This comment has already been created by you'], 418);
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
        return response()->json(
            new CommentResource(Comment::findOrFail($id))
        );
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
        $comment = Comment::findOrFail($id);

        $comment->body = $request->body;


        if ($comment->save()) {
            $comment->message = "Comment ID {$id} successfully updated";
            return response()->json(new CommentResource($comment));
        } else {
            abort(500);
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
        Comment::findOrFail($id)->delete();

        return response()->json((object)['message' => "Comment ID {$id} successfully destroyed"]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Http\Request\CommentRequest;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    protected $commentService;
    protected $postService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentService $commentService, PostService $postService)
    {
        $this->commentService = $commentService;
        $this->postService = $postService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'comment' => 'required',
            ],
            [
                'comment.required' => 'The comment field is required',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), StatusCode::BAD_REQUEST);
        }

        try {
            $postId = $request->post_id;
            $content = $request->comment;
            $userId = !is_null(Auth::user()) ? Auth::user()->id : '';
            $userName = !is_null(Auth::user()) ? Auth::user()->name : '';
            $userImage = !is_null(Auth::user()) ? Auth::user()->image : '';

            $attributes = [
                'post_id' => $postId,
                'content' => $content,
                'user_id' => $userId,
                'user_name' => $userName,
                'user_image' => $userImage
            ];

            $comment = $this->commentService->create($attributes);


            return response()->json(['result' => true], StatusCode::OK);
        } catch (\Exception $e) {
            dd($e);
            Log::info($e);

            return response()->json([
                'message' => StatusCode::INTERNAL_ERR,
            ], StatusCode::INTERNAL_ERR);
        }
    }

    public function edit(CommentRequest $request)
    {
        try {
            $attributes['content'] = $request->contentComment;
            $comment = $this->commentService->update($request->commentId, $attributes);

            return response()->json(['result' => true], StatusCode::OK);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json([
                'message' => StatusCode::INTERNAL_ERR,
            ], StatusCode::INTERNAL_ERR);
        }
    }

    public function delete(Request $request)
    {
        try {
            $commentId = $request->commentId ?? '';
            $comment = $this->commentService->destroy($commentId);

            return response()->json(['result' => true], StatusCode::OK);
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json([
                'message' => StatusCode::INTERNAL_ERR,
            ], StatusCode::INTERNAL_ERR);
        }
    }

    public function  getListComment($postId)
    {
        try{
            $comments = $this->commentService->getListComment($postId);
            $countComment = $this->commentService->countComment($postId);
            return response()->json(['result' => true,'comments' =>$comments,'countComment'=>$countComment], StatusCode::OK);

        }catch (\Exception $e){
            Log::info($e);
            return response()->json([
                'message' => StatusCode::INTERNAL_ERR,
            ], StatusCode::INTERNAL_ERR);
        }

    }
}

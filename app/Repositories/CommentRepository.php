<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class CommentRepository extends BaseRepository
{
    protected $model;

    public function model()
    {
        return Comment::class;
    }

    public function getUserComment($commentId)
    {
        return $this->model->where('id', $commentId)->with('user')->first();
    }

    public function deleteCommentWithPost($postId)
    {
        $this->model->where('post_id', $postId)->delete();
    }

    public function getListComment($postId)
    {
        return $this->model
            ->where('post_id', $postId)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function countComment($postId)
    {
        return $this->model
            ->where('post_id', $postId)
            ->whereNull('deleted_at')
            ->count();
    }
}

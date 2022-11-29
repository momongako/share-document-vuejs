<?php

namespace App\Repositories;

use App\Models\Referrence;

class ReferrenceRepository extends BaseRepository
{

    protected $model;

    public function model()
    {
        return Referrence::class;
    }

    public function getListReferrence($postId)
    {
        return $this->model->where('post_id', $postId)->get();
    }

    public function deletePostReferrence($postId)
    {
        $this->model->where('post_id', $postId)->delete();
    }

}

<?php

namespace App\Repositories;

use App\Models\File;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class FileRepository extends BaseRepository
{
    protected $model;

    public function model()
    {
        return File::class;
    }

    public function deleteFileAttach($postId)
    {
        $this->model->where('post_id', $postId)->delete();
    }

    public function deleteFileAttachById($arraylistFileRemove)
    {
        $this->model->whereIn('id', $arraylistFileRemove)->delete();
    }

    public function getAttachmentNameById($fileIdRemove)
    {
        $data = $this->model->where('id', $fileIdRemove)->first();
        return $data->name;
    }

    public function getFileAttachById($listFileId)
    {
       return $this->model->whereIn('id', $listFileId)->get();
    }

    public function getListAttachment($postId)
    {
        return $this->model->where('post_id', $postId)->get();
    }
}

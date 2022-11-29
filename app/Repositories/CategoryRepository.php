<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CategoryRepository extends BaseRepository
{
    protected $model;

    public function model()
    {
        return Category::class;
    }

    public function getCategoryBySlug($slugCategory)
    {
        return $this->model->where('slug', $slugCategory)->first();
    }

    public function getListCategory()
    {

        $query =  $this->model->orderBy('id', 'DESC');

        //  if (Auth::user()->is_admin !== 1){
        $query->where('user-company', isset(Auth::user()->user_company) ? Auth::user()->user_company : '');
        $query->where('status', 1);
        //  }

        return $query->get();
    }
}
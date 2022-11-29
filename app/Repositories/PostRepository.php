<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Services\Traits\WildCardSQLTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostRepository extends BaseRepository
{
    use WildCardSQLTrait;

    protected $model;

    public function model()
    {
        return Post::class;
    }


    public function searchPostByTitle($request)
    {
        if ($request->title == ''){
            return [];
        }

        $title = $request->title;
        $query = $this->model
            ->where('title', 'LIKE', "%$title%");

        if ($request->postId){
            $query->where('id', '<>', (int) $request->postId);
        }

        $isAdmin = Auth::user()->is_admin;

        if ($isAdmin != 1){
            $userCompany =  isset(Auth::user()->user_company) ? Auth::user()->user_company : '';

            $arrayCategory = $this->getListCategoryPublic();
            $listIdCategoryPublic = [];
            if (!empty($arrayCategory)){
                foreach ($arrayCategory as $caterory){
                    $listIdCategoryPublic[] = $caterory->id;
                }
            }
            if(!empty($listIdCategoryPublic)){
                $query->whereIn('category_id', $listIdCategoryPublic);
            }else{
                return [];
            }

            $query->where('user_company', $userCompany);
        }

        return $query->get();

    }

    public function searchPost($request)
    {

        $query =  $this->model
            ->orderBy('id', 'DESC');

        $isAdmin = Auth::user()->is_admin;
        if(!$request->fromDate && !$request->toDate && !$request->textSearch){

            if($request->categoryId){
                $query->where('category_id', $request->categoryId);
            }

            if ($isAdmin != 1){
                $userCompany =  isset(Auth::user()->user_company) ? Auth::user()->user_company : '';

                $arrayCategory = $this->getListCategoryPublic();
                $listIdCategoryPublic = [];
                if (!empty($arrayCategory)){
                    foreach ($arrayCategory as $caterory){
                        $listIdCategoryPublic[] = $caterory->id;
                    }
                }
                if(!empty($listIdCategoryPublic)){
                    $query->whereIn('category_id', $listIdCategoryPublic);
                }else{
                    return [];
                }

                $query->where('user_company', $userCompany);
            }

            return $query->paginate(LIMIT_POST);
        }


        if ($request->fromDate){
            $fromDate = substr($request->fromDate,0,10) ." 00:00:00";
            $fromDateSearch = date('Y-m-d H:i:s', strtotime($fromDate . ' +1 day'));

            $query->where('created_at', '>=', $fromDateSearch);
        }

        if ($request->toDate){
            $toDate = substr($request->toDate,0,10) ." 23:59:59";
            $toDateSearch = date('Y-m-d H:i:s', strtotime($toDate . ' +1 day'));

            $query->where('created_at', '<=', $toDateSearch);
        }

        $textSearch = $request->textSearch;

        if ($textSearch){
            $query->where(function ($subQuery) use ($textSearch) {
                $subQuery->where('title', 'LIKE', "%$textSearch%");
                $subQuery->orwhere('user_name', 'LIKE', "%$textSearch%");
            });

        }

        if($request->categoryId){
            $query->where('category_id', $request->categoryId);
        }

        if ($isAdmin != 1){
            $userCompany =  isset(Auth::user()->user_company) ? Auth::user()->user_company : '';

            $arrayCategory = $this->getListCategoryPublic();
            $listIdCategoryPublic = [];
            if (!empty($arrayCategory)){
                foreach ($arrayCategory as $caterory){
                    $listIdCategoryPublic[] = $caterory->id;
                }
            }
            if(!empty($listIdCategoryPublic)){
                $query->whereIn('category_id', $listIdCategoryPublic);
            }else{
                return [];
            }
            $query->where('user_company', $userCompany);
        }

        return $query->paginate(LIMIT_POST);

    }

    public function getListPostCategory($categoryId, $search, $filterLastPost, $filterMostView)
    {
        $isAdmin = Auth::user()->is_admin;
        $query = $this->model
            ->where('category_id', $categoryId)
            ->where('status', ACTIVE)
            ->orWhere(function ($subQuery) use ($isAdmin) {
                $subQuery->where('status', DEACTIVE);

                if ($isAdmin != ADMIN) {
                    $subQuery->where('user_id', Auth::user()->id);
                }
            })
            ->with('user', 'comment.user', 'likePost', 'file')
            ->orderBy('is_pin', 'ASC');

        if ($search) {
            $query->where('title', 'like', '%' . $this->escapeLike($search) . '%');
        }

        if ($filterMostView === FILTER_ASC) {
            $query->orderBy('view', FILTER_ASC);
        } elseif($filterMostView === FILTER_DESC) {
            $query->orderBy('view', FILTER_DESC);
        }

        if ($filterLastPost === FILTER_ASC) {
            $query->orderBy('created_at', FILTER_ASC);
        } elseif(!$filterMostView) {
            $query->orderBy('created_at', FILTER_DESC);
        }

        return $query->get();
    }

    public function firstPostCategory($categoryId, $search, $filterLastPost, $filterMostView)
    {
        $query = $this->model
            ->where('category_id', $categoryId)
            ->with('user', 'comment.user', 'likePost', 'file')
            ->orderBy('is_pin', 'ASC');

        if ($search) {
            $query->where('title', 'like', '%' . $this->escapeLike($search) . '%');
        }

        if ($filterMostView === FILTER_ASC) {
            $query->orderBy('view', FILTER_ASC);
        } elseif($filterMostView === FILTER_DESC) {
            $query->orderBy('view', FILTER_DESC);
        }

        if ($filterLastPost === FILTER_ASC) {
            $query->orderBy('created_at', FILTER_ASC);
        } elseif(!$filterMostView) {
            $query->orderBy('created_at', FILTER_DESC);
        }

        return $query->first();
    }

    public function getPostById($postId)
    {
        return $this->model
            ->where('id', $postId)
            ->with('user', 'comment.user', 'likePost', 'file')
            ->first();
    }

    public function getActivePost($type,$postId,$arrayCategoryId)
    {
        $query =  $this->model
             ->where('id', $postId)
            ->whereIn('category_id', $arrayCategoryId);

        $isAdmin = Auth::user()->is_admin;
        if ($isAdmin != 1){
            if ($type == 'editPost'){
                $query->where('user_id', Auth::user()->id);
            }
        }

        return $query->get();
    }

    public function getListPost()
    {
        $isAdmin = Auth::user()->is_admin;

        $query =  $this->model
            ->orderBy('id', 'DESC');

        if ($isAdmin != 1){
            $userCompany =  isset(Auth::user()->user_company) ? Auth::user()->user_company : '';

            $arrayCategory = $this->getListCategoryPublic();
            $listIdCategoryPublic = [];
            if (!empty($arrayCategory)){
                foreach ($arrayCategory as $caterory){
                    $listIdCategoryPublic[] = $caterory->id;
                }
            }
            if(!empty($listIdCategoryPublic)){
                $query->whereIn('category_id', $listIdCategoryPublic);
            }else{
                return [];
            }

            $query->where('user_company', $userCompany);
        }


        return $query->paginate(LIMIT_POST);
    }

    public  function getListPostByCategoryId($categoryId)
    {
        return $this->model
            ->where('category_id', $categoryId)
            ->orderBy('id', 'DESC')
            ->paginate(LIMIT_POST);
    }


    public function listPostAddReferrence($arrayIdReferrence)
    {
        return $this->model
            ->whereIn('id', $arrayIdReferrence)
            ->get();
    }
    public function getListCategoryPublic(){
        return DB::table('categories')->where('status', 1)->get();
    }

    public function incrementViewPost($postId)
    {
        DB::table('posts')->where('id', $postId)->increment('view');
    }
}

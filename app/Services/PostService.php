<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\Traits\ImageManagerTrait;
use App\Services\Traits\WildCardSQLTrait;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 *
 * @package App\Services
 */
class PostService extends BaseService
{
    use WildCardSQLTrait;
    use ImageManagerTrait;

    /**
     * @var PostRepository
     */
    protected $mainRepository;

    protected $categoryService;

    /**
     * OptionService constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository, CategoryService $categoryService)
    {
        $this->mainRepository = $postRepository;
        $this->categoryService = $categoryService;
    }

    public function getAllPostPinned()
    {
        return $this->mainRepository->getListPostPinned();
    }

    public function getPostById($postId)
    {
        return $this->mainRepository->getPostById($postId);
    }

     public function getListPost()
     {
        return $this->mainRepository->getListPost();
     }

     public function getActivePost($type,$postId,$arrayCategoryId){
         return $this->mainRepository->getActivePost($type,$postId,$arrayCategoryId);
     }

     public function getListPostByCategoryId($categoryId){
         return $this->mainRepository->getListPostByCategoryId($categoryId);
     }

    public function getAttributePost($request)
    {
        if ($request->id){
            $attributesPost = [
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'category_name' => $this->getCategoryName($request->category_id),
                'has_attachment'=> 1
            ];
        }
        else{
            $attributesPost = [
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category_id,
                'category_name' => $this->getCategoryName($request->category_id),
                'user_id' => isset(Auth::user()->id) ? Auth::user()->id : '1',
                'user_name' => isset(Auth::user()->name) ? Auth::user()->name : '',
                'user_company' => isset(Auth::user()->user_company) ? Auth::user()->user_company : '',
                'has_attachment'=> 1
            ];
        }

        return $attributesPost;
    }

    public function getCategoryName($id)
    {
        $category = $this->categoryService->find($id);
        return $category['name'] ?? '';
    }

    public function getPostTitle($id)
    {
        $postTitle = $this->find($id);

        return $postTitle['title'] ?? '';
    }

    public function listPostAddReferrence($arrayIdReferrence)
    {
        return $this->mainRepository->listPostAddReferrence($arrayIdReferrence);
    }


    public function uploadAttachmentPost($listFileUpload, $postId)
    {
        $listFile = [];
        $userId = !is_null(Auth::user()) ? Auth::user()->id : 'user';
        $folderName = PATH_UPLOAD_FILE . $userId . "/attachment/" . $postId;
        foreach ($listFileUpload as $file) {
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $this->uploadFile($folderName, $file, $fileName);
            $path = "posts/" . $userId . "/attachment/" . $postId . "/" . $fileName;
            $listFile[] = [
                'name' => $fileName,
                'path' => $path,
                'post_id' => $postId,
                'size'  => $fileSize
            ];
        }

        return $listFile;
    }

    public function incrementViewPost($postId)
    {
        $this->mainRepository->incrementViewPost($postId);
    }

    public function searchPostByTitle($request)
    {
         return $this->mainRepository->searchPostByTitle($request);
    }

    public function searchPost($request)
    {
        return $this->mainRepository->searchPost($request);
    }
}


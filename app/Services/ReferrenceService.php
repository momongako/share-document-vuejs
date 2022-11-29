<?php

namespace App\Services;

use App\Repositories\ReferrenceRepository;
use App\Services\PostService;


/**
 * Class UserService
 *
 * @package App\Services
 */
class ReferrenceService extends BaseService
{

    /**
     * @var ReferrenceRepository
     */
    protected $mainRepository;

    protected $postService;

    /**
     * OptionService constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(
        ReferrenceRepository $referrenceRepository,
        PostService $postService
    )
    {
        $this->mainRepository = $referrenceRepository;
        $this->postService = $postService;
    }


    public function getAttributeReferrence($postIdReferrence,$postId)
    {
        return
            [
                'post_id' => $postId,
                'post_id_referrence' => $postIdReferrence,
                'post_name_referrence' => $this->postService->getPostTitle($postIdReferrence)
            ];
    }

    public function getListReferrence($postId)
    {
        return $this->mainRepository->getListReferrence($postId);
    }

    public function deletePostReferrence($postId){
        return $this->mainRepository->deletePostReferrence($postId);
    }

}


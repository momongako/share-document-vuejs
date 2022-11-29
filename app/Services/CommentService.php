<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Services\Traits\WildCardSQLTrait;

/**
 * Class UserService
 *
 * @package App\Services
 */
class CommentService extends BaseService
{
    use WildCardSQLTrait;

    /**
     * @var Comment
     */
    protected $mainRepository;

    /**
     * OptionService constructor.
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->mainRepository = $commentRepository;
    }

    public function getUserComment($commentId)
    {
        return $this->mainRepository->getUserComment($commentId);
    }

    public function deleteCommentWithPost($postId)
    {
        $this->mainRepository->deleteCommentWithPost($postId);
    }

    public function getListComment($postId)
    {
        return $this->mainRepository->getListComment($postId);
    }

    public function countComment($postId)
    {
        return $this->mainRepository->countComment($postId);
    }
}


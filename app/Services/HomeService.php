<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Services\Traits\WildCardSQLTrait;

/**
 * Class UserService
 *
 * @package App\Services
 */
class HomeService extends BaseService
{
    use WildCardSQLTrait;

    /**
     * @var PostRepository
     */
    protected $mainRepository;

    /**
     * OptionService constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->mainRepository = $postRepository;
    }

    public function getListPostPinned()
    {
       return $this->mainRepository->getListPostPinned();
    }

    public function getListNewDaily()
    {
       return $this->mainRepository->getListNewDaily();
    }

    public function getListPostEvent()
    {
       return $this->mainRepository->getListPostEvent();
    }
}


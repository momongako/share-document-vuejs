<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Services\Traits\WildCardSQLTrait;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 *
 * @package App\Services
 */
class CategoryService extends BaseService
{
    use WildCardSQLTrait;

    /**
     * @var CategoryRepository
     */
    protected $mainRepository;

    /**
     * OptionService constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->mainRepository = $categoryRepository;
    }

    public function getAttributeCategory($request)
    {
        $attributesCategory = [
            'name'           => $request->input('name'),
            'description'    => $request->input('description') != '' ? $request->input('description') : '' ,
            'status'         => $request->input('status'),
            'user-company'   => isset(Auth::user()->user_company) ? Auth::user()->user_company : ''
        ];

        return $attributesCategory;
    }

    public function getListCategory()
    {
        return $this->mainRepository->getListCategory();
    }

}


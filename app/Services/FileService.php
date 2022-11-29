<?php

namespace App\Services;

use App\Repositories\FileRepository;
use App\Services\Traits\WildCardSQLTrait;

/**
 * Class UserService
 *
 * @package App\Services
 */
class FileService extends BaseService
{
    use WildCardSQLTrait;

    /**
     * @var FileRepository
     */
    protected $mainRepository;

    /**
     * OptionService constructor.
     *
     * @param FileRepository $fileRepository
     */
    public function __construct(FileRepository $fileRepository)
    {
        $this->mainRepository = $fileRepository;
    }

    public function deleteFileAttach($postId)
    {
        return $this->mainRepository->deleteFileAttach($postId);
    }

    public function deleteFileAttachById($arraylistFileRemove)
    {
        return $this->mainRepository->deleteFileAttachById($arraylistFileRemove);
    }

    public function getAttachmentNameById($fileIdRemove)
    {
        return $this->mainRepository->getAttachmentNameById($fileIdRemove);
    }

    public function getFileAttachById($listFileId)
    {
        return $this->mainRepository->getFileAttachById($listFileId);
    }

    public function getListAttachment($postId)
    {
        return $this->mainRepository->getListAttachment($postId);
    }
}


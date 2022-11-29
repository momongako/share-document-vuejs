<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Http\Request\CategoryRequest;
use App\Models\File;
use App\Models\Post;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\ReferrenceService;
use App\Services\FileService;
use App\Services\PostService;
use App\Services\Traits\ImageManagerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isNull;
use ZipArchive;
use File as FileDownload;

class PostController extends Controller
{
    use ImageManagerTrait;

    protected $postService;
    protected $fileService;
    protected $categoryService;
    protected $commentService;
    protected $referrenceService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PostService $postService,
        FileService $fileService,
        CategoryService $categoryService,
        CommentService $commentService,
        ReferrenceService $referrenceService
    )
    {
        $this->postService = $postService;
        $this->fileService = $fileService;
        $this->categoryService = $categoryService;
        $this->commentService = $commentService;
        $this->referrenceService = $referrenceService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        //$this->authorize('create', Post::class);
        $listFile = [];

        $this->validate($request, [
            'title'   => 'required|max:255',
            'content'   => 'required',
            'category_id'   => 'required',
        ]);

        $attributesPost = $this->postService->getAttributePost($request);
        $post = $this->postService->create($attributesPost);

        if ($request->file('filesAttach')) {
            $listFileUpload = $request->file('filesAttach');
            $listFile = $this->postService->uploadAttachmentPost($listFileUpload, $post->id);
            $this->fileService->inserts($listFile);
        }

        if($request->referrence){

            $arrayPostIdReferrence = $request->referrence;
            foreach ($arrayPostIdReferrence as $postIdReferrence){
                $attributesReferrence = $this->referrenceService->getAttributeReferrence($postIdReferrence,$post->id);
                $this->referrenceService->create($attributesReferrence);

            }

        }

        return response()->json(['result' => true,'postId' => $post->id], StatusCode::OK);
    }

    public function getListPost()
    {
        $listPost =  $this->postService->getListPost();
        return response([
            'listpost' => $listPost
        ], StatusCode::OK);

    }

    public function getDetailPost(Request $request)
    {
        $post =   $this->postService->find($request->id);
        $listAttachment = $this->fileService->getListAttachment($request->id);
        $listAttachmentAdded =[];
        if (!empty($listAttachment)){

            foreach ($listAttachment as $key => $value ){
                $listAttachmentAdded[] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'size' => $value->size
                ];
            }
        }


        $listReferrence = $this->referrenceService->getListReferrence($request->id);
        $arrayIdReferrence = [];
        $listPostAddReferrence = [];
        if (!empty($listReferrence)){
            foreach ($listReferrence as $key => $value ){
                $arrayIdReferrence[] = (int)$value->post_id_referrence;
            }
            $listPostAddReferrence = $this->postService->listPostAddReferrence($arrayIdReferrence);
        }

        $hasAccess = false;

        $hasShowDetail = false;
        $hasShowEdit = false;

        $listActiveCategory = $this->categoryService->getListCategory();
        $arrayCategoryId = [];
        if (!empty($listActiveCategory)){
            foreach ($listActiveCategory as $activeCategory){
                $arrayCategoryId[] = $activeCategory->id;
            }
            $listActivePost = $this->postService->getActivePost($request->type,$request->id,$arrayCategoryId);
            if(count($listActivePost) > 0){
                $hasShowDetail = true;
                $hasShowEdit = true;
            }

        }

        if (is_null($post)){
            $hasShowDetail = false;
            $hasShowEdit = false;
        }

        if ($request->type == 'detailPost'){
            if($hasShowDetail === true)
            {
                $hasAccess = true;
            }
        }
        if ($request->type == 'editPost'){
            if( $hasShowEdit === true)
            {
                $hasAccess = true;
            }
        }


        return response(
            [
            'post' => $post,
            'listAttachment' => $listAttachment,
            'listAttachmentAdded' => $listAttachmentAdded,
            'listReferrence'=> $listReferrence,
            'listPostAddReferrence'=> $listPostAddReferrence,
            'arrayIdReferrence' => $arrayIdReferrence,
            'hasAccess'  => $hasAccess
            ], StatusCode::OK);
    }

    public function getListFileAttachment($postId)
    {
        return $this->fileService->getListAttachment($postId);
    }

    public function getListPostByCategoryId(Request $request)
    {
        $listPost =  $this->postService->getListPostByCategoryId($request->id);
        return response([
            'listpost' => $listPost
        ], StatusCode::OK);

    }

    public function edit(Request $request)
    {
        $attributesPost = $this->postService->getAttributePost($request);

        $this->postService->update($request->id, $attributesPost);

        if($request->listFileRemove){
            $arraylistFileRemove = explode(",",$request->listFileRemove);
            foreach ($arraylistFileRemove as $fileIdRemove){
                $fileName = $this->fileService->getAttachmentNameById($fileIdRemove);
                $userId = !is_null(Auth::user()) ? Auth::user()->id : 'user';
                $path = PATH_UPLOAD_FILE . $userId . "/attachment/" . $request->id;

                if(Storage::exists($path.'/'.$fileName)){
                    Storage::delete($path.'/'.$fileName);
                }
            }

            $this->fileService->deleteFileAttachById($arraylistFileRemove);

        }

        if ($request->file('filesAttach')) {
            $listFileUpload = $request->file('filesAttach');
            $listFile = $this->postService->uploadAttachmentPost($listFileUpload, $request->id);
            $this->fileService->inserts($listFile);

        }

        if ($request->referrence)
        {
            $this->referrenceService->deletePostReferrence($request->id);

            $arrayPostIdReferrence = explode(",",$request->referrence);

            foreach ($arrayPostIdReferrence as $postIdReferrence){
                $attributesReferrence = $this->referrenceService->getAttributeReferrence($postIdReferrence,$request->id);
                $this->referrenceService->create($attributesReferrence);

            }
        }

        return response()->json(['result' => true], StatusCode::OK);
    }

    public function getListPostEvent()
    {
        $data = $this->postService->getListPostEvent();

        return response()->json($data);
    }

    public function delete(Request $request)
    {
        $postId = $request->postId;
        DB::beginTransaction();
        try {
            $this->postService->destroy($postId);
            $this->fileService->deleteFileAttach($postId);
            $this->commentService->deleteCommentWithPost($postId);
            DB::commit();

            return response()->json(['result' => true], StatusCode::OK);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();

            return  response()->json(['error' => true], StatusCode::INTERNAL_ERR);
        }
    }

    public function incrementViewPost(Request $request)
    {
        $postId = $request->postId ?? '';

        try{
            $this->postService->incrementViewPost($postId);
            return response()->json(['result' => true], StatusCode::OK);
        }
        catch (\Exception $exception){
            return  response()->json(['error' => true], StatusCode::INTERNAL_ERR);
        }
    }

    public function downloadFile(Request $request)
    {
        return $this->downloadFileAttach($request->file);
    }

    public function zipAndDownloadFie($postId)
    {
        $zip = new ZipArchive();
        $fileName = "document".date("Y.m.d H.i.s").".zip";
        $userId = !is_null(Auth::user()) ? Auth::user()->id : 'user';

        $attachments = $this->getListFileAttachment($postId);

        if (count($attachments) == 1){
                foreach ($attachments as $attachments){
                    return Storage::download('public/' . $attachments->path);
                }
        }
        else{
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE){
                $files = FileDownload::files('storage/posts/' . $userId . "/attachment/" . $postId);
                foreach ($files as $key => $value)
                {
                    $relativeNameZipFile = basename($value);
                    $zip->addFile($value,$relativeNameZipFile);
                }
                $zip->close();


                return  response()->download(public_path($fileName));
            }
        }
    }

    public function searchPostByTitle(Request $request)
    {

        $data = $this->postService->searchPostByTitle($request);

        return response()->json($data);
    }

    public function searchPost(Request $request)

    {
        $data = $this->postService->searchPost($request);
        return response()->json($data);
    }
}

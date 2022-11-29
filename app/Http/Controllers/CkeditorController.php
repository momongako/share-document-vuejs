<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Services\Traits\ImageManagerTrait;
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    use ImageManagerTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function uploadImageCkeditor(Request $request)
    {
        if ($request->file('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = $this->uploadFileName(empty($extension) ? 'png' : $extension);
            $folderName = PATH_UPLOAD_FILE_CKEDITOR;
            $this->uploadFile($folderName, $file, $fileName);
            $path = PATH_LOAD_FILE_CKEDITOR . $fileName;

            return response()->json(['result' => true, 'path' => $path], StatusCode::OK);
        }
    }
}

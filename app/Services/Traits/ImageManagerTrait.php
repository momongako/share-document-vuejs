<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Http\Request;
use Carbon\Carbon;

trait ImageManagerTrait
{
    protected $allow = ['png', 'jpg', 'svg', 'jpeg', 'gif'];

    public function imageStore($param, $folder = '')
    {
        if (!$this->validateImageBase64($param)) {
            return false;
        }

        list($extension, $content) = explode(';', $param);
        $tmpExtension = explode('/', $extension);
        preg_match('/.([0-9]+) /', microtime(), $m);
        $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
        $content = explode(',', $content)[1];
        $storage = Storage::disk();

        $checkDirectory = $storage->exists($folder);

        if (!$checkDirectory) {
            $storage->makeDirectory($folder);
        }

        $storage->put('images/'. $folder . '/' . $fileName, base64_decode($content), 'public');

        return 'images/'. $folder . '/' . $fileName;
    }

    public function imageLocalStore($file, $nameFile, $path = '')
    {
        return $file->storePubliclyAs($path, $nameFile, 'public');
    }

    public function validateImageBase64($param)
    {
        $explode = explode(',', $param);
        $allow = ['png', 'jpg', 'svg', 'jpeg'];
        $format = str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $explode[0]
        );

        if (!in_array($format, $allow)) {
            return false;
        }

        return true;
    }

    public function putMultiImageToS3(Request $request, $inputName, $folder = '')
    {
        $images = [];
        try {
            if ($request->hasFile($inputName)) {
                foreach($request->file($inputName) as $file) {
                    $ext = $file->getClientOriginalExtension();
                    if(in_array(strtolower($ext), $this->allow) ) {
                        $filePath = Storage::cloud('s3')->put($folder, $file);

                        $images[] = $this->getImageUrlS3($filePath);
                    }
                }
            }

            return $images;
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return false;
    }

    public function putImageToS3(Request $request, $inputName, $folder = '')
    {
        try {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $ext = $file->getClientOriginalExtension();
                if(in_array(strtolower($ext), $this->allow) ) {
                    $filePath = Storage::cloud('s3')->put($folder, $file);

                    return $this->getImageUrlS3($filePath);
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return false;
    }

    public function getImageUrlS3($filePath, $temporary = false)
    {
        try {
            $exists = Storage::cloud('s3')->has($filePath);
            if ($exists) {
                if ($temporary) {
                    return Storage::disk('s3')->temporaryUrl(
                        $filePath,
                        Carbon::now()->addMinutes(60)
                    );
                }

                return Storage::cloud('s3')->url($filePath);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return null;
        }
    }

    public function deleteS3Image($filePath): bool
    {
        try {
            return Storage::disk('s3')->delete($filePath);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public static function uploadFile($folder, $file, $fileName)
    {
        try {
            $path = Storage::putFileAs($folder, $file, $fileName);

            return true;
        } catch (Exception $exception) {
            Log::info(['Upload fail' => $exception->getMessage()]);
            return false;
        }

        return true;
    }

    public static function uploadFileName( $extension = '' )
    {
        return sha1(time() . rand(0, 9999999)) . "." . $extension;
    }

    public function deleteFile($filePath)
    {
        try {
            if(Storage::disk('public')->exists($filePath)){
                Storage::disk('public')->delete($filePath);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function deleteFolder($folderPath)
    {
        try {
            Storage::deleteDirectory($folderPath);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }

    public function downloadFileAttach($filePath)
    {
        try {
            return Storage::download('public/' . $filePath);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return false;
        }
    }
}

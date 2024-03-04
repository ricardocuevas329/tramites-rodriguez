<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait UploadFileStorage
{
    public function generateURLSignatureTemp(string|null $file): string
    {
        if ($file) {
            $cacheKey = 'signed_url_' . $file;
            return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($file) {
                $disk = Storage::disk('s3');
                $client =  $disk->getClient();

                $command = $client->getCommand('GetObject', [
                    'Bucket' => config('app.AWS_BUCKET'),
                    'Key' => str_replace("https://" . config('app.AWS_BUCKET') . ".s3.amazonaws.com/", "", $file),
                ]);

                $request = $client->createPresignedRequest($command, '+15 minutes');

                return (string)$request->getUri();
            });
        }
        return "";
    }



    public function UploadImageStorage($request, string $folder, string $extension)
    {
        Image::configure(['driver' => 'gd']);
        $image = Image::make($request);

        $image->resize(500, 333, function ($constraint) {
            $constraint->aspectRatio();
            //$constraint->upsize();
        });
        $image->encode($extension, 64);
        $name = uniqid() . '.' . $extension;
        Storage::disk('public')->put($folder . '/' . $name, (string)$image);
        return asset("storage/$folder/" . $name);
    }


    public function UploadFilesS3($base64, string $folder, string $ext = '')
    {
        if ($base64) {
            if (filter_var($base64, FILTER_VALIDATE_URL)) {
                return $base64;
            }
            $base64file = explode(";base64,", $base64);
            $extension = $this->getExtensionNameFromBase64($base64);

            $file_base64 = base64_decode($base64file[1]);

            try {
                $s3Url = $folder . '/' . uniqid() . '.' . $extension;
                $s3 = Storage::disk('s3')->put($s3Url, $file_base64);
                return Storage::disk('s3')->url($s3Url);
            } catch (Exception $e) {
            }
        }
    }

    /*
    public function getExtensionNameFromBase64(string $base64): string|bool
    {
        preg_match('/^data:(.*);base64/', $base64, $match);
        $mimeType = $match[1];
        $extension = \Symfony\Component\Mime\MimeTypes::getDefault()->getExtensions($mimeType)[0];
        if ($extension) {
            return $extension;
        }
        return false;
    }*/
    public function getExtensionNameFromBase64(string $base64): string|bool
    {
        if (preg_match('/^data:(.*);base64/', $base64, $match)) {
            $mimeType = $match[1];
            $extension = \Symfony\Component\Mime\MimeTypes::getDefault()->getExtensions($mimeType)[0] ?? false;
            if ($extension) {
                return $extension;
            }
        }
        return false;
    }
}

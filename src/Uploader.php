<?php

namespace ZMDev\ImageUploader;


use Illuminate\Http\UploadedFile;
use ZMDev\ImageUploader\Exceptions\ImageUploaderException;

abstract class Uploader implements IUploader
{
    /**
     * @param $file
     * @return UploadedFile
     * @throws ImageUploaderException
     */
    protected function convertUploaderFile($file)
    {
        if ($this->isUrl($file)) {
            $tempFile = $this->createTempFileFromUrl($file);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $tempFile);
            finfo_close($finfo);
            $originName = preg_replace('/\W/', '', pathinfo($file, PATHINFO_BASENAME));
            $originName = str_limit($originName, 100, '');
            if ($originName == '') {
                $originName = str_random();
            }
            $file = new UploadedFile($tempFile, $originName, $mime, null, true);
        }

        /**
         * @var $file UploadedFile
         */
        if (!($file instanceof UploadedFile) || !$file->isValid()) {
            $error = $file instanceof UploadedFile ? $file->getErrorMessage() : '图片上传失败';
            throw new ImageUploaderException($error);
        }

        $mime = $file->getMimeType();
        if (is_null($mime) || !str_start($mime, 'image/')) {
            throw new ImageUploaderException('上传的不是图片文件');
        }
        return $file;
    }

    private function createTempFileFromUrl($url)
    {
        $options = [
            'http' => [
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2\r\n"
            ]
        ];

        $context = stream_context_create($options);

        $tempName = tempnam(sys_get_temp_dir(), config('app.name'));
        if (!$tempName) {
            throw new ImageUploaderException('临时文件创建失败');
        }
        if ($data = @file_get_contents($url, false, $context)) {
            @file_put_contents($tempName, $data);
        }
        return $tempName;
    }

    private function isUrl($url)
    {
        return (bool)filter_var($url, FILTER_VALIDATE_URL);
    }

    protected function storeToDB($hashValue, $mime, $name, \SplFileInfo $fileInfo)
    {
        list($width, $height) = getimagesize($fileInfo->getRealPath());
        return Image::create([
            'hash' => $hashValue,
            'format' => substr(strstr($mime, '/'), 1),
            'title' => $name,
            'width' => $width,
            'height' => $height,
        ]);
    }
}
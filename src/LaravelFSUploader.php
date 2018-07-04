<?php

namespace ZMDev\ImageUploader;


use Illuminate\Http\UploadedFile;

class LaravelFSUploader extends Uploader
{
    private $disk;

    /**
     * LaravelFSUploader constructor.
     * @param $disk
     */
    public function __construct($disk)
    {
        $this->disk = $disk;
    }

    public function upload($file)
    {
        /**
         * @var $file UploadedFile
         */
        $file = $this->convertUploaderFile($file);
        /**
         * @var $hasher IHasher
         */
        $hasher = app(IHasher::class);
        $hashValue = $hasher->hash($file);
        $image = Image::find($hashValue);
        if (!is_null($image)) {
            // 图片已经存在
            return $image;
        }
        $file->storeAs('', $hashValue, ['disk' => $this->disk]);
        return $this->storeToDB($hashValue, $file->getMimeType(), $file->getClientOriginalName(), $file);
    }

}

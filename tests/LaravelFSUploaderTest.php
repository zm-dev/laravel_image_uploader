<?php

namespace ZMDev\ImageUploader\Test;


use Illuminate\Http\UploadedFile;
use ZMDev\ImageUploader\Image;
use ZMDev\ImageUploader\LaravelFSUploader;

class LaravelFSUploaderTest extends TestCase
{
    public function testUpload()
    {
        $name = 'avatar.jpg';
        $width = 100;
        $height = 200;
        $file = UploadedFile::fake()->image($name, $width, $height)->size(500);
        $uploader = new LaravelFSUploader('local');
        $image = $uploader->Upload($file);
        $this->assertTrue($image instanceof Image, '图片上传出错了');
        $this->assertSame($width, $image->width);
        $this->assertSame($height, $image->height);
        $this->assertSame('jpeg', $image->format);
        $this->assertSame($name, $image->title);
    }
}

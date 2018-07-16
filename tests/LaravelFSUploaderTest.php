<?php

namespace ZMDev\ImageUploader\Test;


use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use ZMDev\ImageUploader\Exceptions\ImageUploaderException;
use ZMDev\ImageUploader\Image;
use ZMDev\ImageUploader\LaravelFSUploader;

class LaravelFSUploaderTest extends TestCase
{
    use WithFaker;

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

    public function testUploadImageURL()
    {

        $width = 100;
        $height = 200;
        $imageURL = $this->faker()->imageUrl($width, $height);
        $uploader = new LaravelFSUploader('local');
        $image = $uploader->Upload($imageURL);
        $this->assertTrue($image instanceof Image, '图片上传出错了');
        $this->assertSame($width, $image->width);
        $this->assertSame($height, $image->height);
    }

    public function testUploadWithInvalidImageURL1()
    {
        $uploader = new LaravelFSUploader('local');
        $this->expectException(ImageUploaderException::class);
        $uploader->Upload('123');
    }

    public function testUploadWithInvalidImageURL2()
    {
        $uploader = new LaravelFSUploader('local');
        $this->expectException(ImageUploaderException::class);
        $uploader->Upload('');
    }

    public function testUploadWithInvalidImageURL3()
    {
        $uploader = new LaravelFSUploader('local');
        $this->expectException(ImageUploaderException::class);
        $uploader->Upload(false);
    }

    public function testUploadWithInvalidImageURL4()
    {
        $uploader = new LaravelFSUploader('local');
        $this->expectException(ImageUploaderException::class);
        $uploader->Upload(null);
    }
}

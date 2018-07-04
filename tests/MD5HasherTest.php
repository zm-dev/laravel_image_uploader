<?php

namespace ZMDev\ImageUploader\Test;

use ZMDev\ImageUploader\MD5Hasher;
use SplFileInfo;

class MD5HasherTest extends TestCase
{
    public function testHash()
    {
        $hasher = new MD5Hasher();
        $file = new SplFileInfo(__DIR__ . '/testdata/laravel.png');
        $this->assertSame('ed7f18602855dea2053e6c0b95dcddab', $hasher->hash($file));
    }
}

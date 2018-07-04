<?php

namespace ZMDev\ImageUploader\Test\ImageURL;


use ZMDev\ImageUploader\ImageURL\ImageproxyURL;
use ZMDev\ImageUploader\ImageURL\Option;
use ZMDev\ImageUploader\Test\TestCase;

class ImageproxyURLTest extends TestCase
{

    public function testGenerate()
    {
        $tests = [
            [
                'http://image.test/',
                'http://minio:9000',
                'fate',
                true,
                'abcdefgheight123456789',
                [Option::Width(100), Option::Height(200), Option::Quality(100)],
                'http://image.test/100x200/fate/abcdefgheight123456789'
            ],
            [
                'http://image.test/',
                'http://minio:9000',
                'fate',
                false,
                'abcdefgheight123456789',
                [Option::Width(100), Option::Height(200), Option::Quality(100)],
                'http://image.test/100x200/http://minio:9000/fate/abcdefgheight123456789'
            ],
            [
                'http://image.test/',
                'http://minio:9000',
                'fate',
                false,
                'abcdefgheight123456789',
                [Option::Height(200), Option::Quality(80)],
                'http://image.test/x200,q80/http://minio:9000/fate/abcdefgheight123456789'
            ],
            [
                'http://image.test/',
                'http://minio:9000',
                'fate',
                false,
                'abcdefgheight123456789',
                [Option::WidthPercent(0.6), Option::HeightPercent(0.5), Option::Quality(80)],
                'http://image.test/0.6x0.5,q80/http://minio:9000/fate/abcdefgheight123456789'
            ],
        ];
        foreach ($tests as $test) {
            $imageproxyURL = new ImageproxyURL($test[0], $test[1], $test[2], $test[3]);
            $this->assertSame($test[6], $imageproxyURL->Generate($test[4], ...$test[5]), 'url 生成错误');
        }
    }
}

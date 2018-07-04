<?php

namespace ZMDev\ImageUploader;


class MD5Hasher implements IHasher
{
    public function hash(\SplFileInfo $file){
        return md5_file($file->getRealPath());
    }
}

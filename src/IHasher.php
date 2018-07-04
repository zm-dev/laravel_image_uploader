<?php

namespace ZMDev\ImageUploader;

interface IHasher{
    function hash(\SplFileInfo $file);
}
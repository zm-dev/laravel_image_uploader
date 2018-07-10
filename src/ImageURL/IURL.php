<?php


namespace ZMDev\ImageUploader\ImageURL;

use Closure;

interface IURL
{
    function generate($hashValue, Closure ...$optCallbacks);
}

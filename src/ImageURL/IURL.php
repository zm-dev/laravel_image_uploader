<?php


namespace ZMDev\ImageUploader\ImageURL;

use Closure;

interface IURL
{
    function Generate($hashValue, Closure ...$optCallbacks);
}

<?php

namespace ZMDev\ImageUploader;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $fillable = ['hash', 'format', 'title', 'width', 'height'];
    protected $primaryKey = 'hash';
    public $incrementing = false;
}
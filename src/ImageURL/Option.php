<?php

namespace ZMDev\ImageUploader\ImageURL;


class Option
{
    private $width;
    private $height;
    private $widthPercent;
    private $heightPercent;
    private $quality;

    /**
     * Option constructor.
     * @param $width
     * @param $height
     * @param $widthPercent
     * @param $heightPercent
     * @param $quality
     */
    public function __construct($width = null, $height = null, $widthPercent = null, $heightPercent = null, $quality = null)
    {
        $this->width = $width;
        $this->height = $height;
        $this->widthPercent = $widthPercent;
        $this->heightPercent = $heightPercent;
        $this->quality = $quality;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getWidthPercent()
    {
        return $this->widthPercent;
    }

    /**
     * @param mixed $widthPercent
     */
    public function setWidthPercent($widthPercent)
    {
        $this->widthPercent = $widthPercent;
    }

    /**
     * @return mixed
     */
    public function getHeightPercent()
    {
        return $this->heightPercent;
    }

    /**
     * @param mixed $heightPercent
     */
    public function setHeightPercent($heightPercent)
    {
        $this->heightPercent = $heightPercent;
    }

    /**
     * @return mixed
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param mixed $quality
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    public static function Width($width)
    {
        return function (Option $option) use ($width) {
            $option->setWidth($width);
        };
    }

    public static function Height($height){
        return function (Option $option) use ($height) {
            $option->setHeight($height);
        };
    }

    public static function WidthPercent($widthPercent){
        return function (Option $option) use ($widthPercent) {
            $option->setWidthPercent($widthPercent);
        };
    }

    public static function HeightPercent($heightPercent){
        return function (Option $option) use ($heightPercent) {
            $option->setHeightPercent($heightPercent);
        };
    }

    public static function Quality($quality){
        return function (Option $option) use ($quality) {
            $option->setQuality($quality);
        };
    }
}

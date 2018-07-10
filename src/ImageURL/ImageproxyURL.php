<?php

namespace ZMDev\ImageUploader\ImageURL;

use Closure;

class ImageproxyURL implements IURL
{
    private $imageproxyHost;
    private $baseURL;
    private $bucketName;
    private $omitBaseURL;

    /**
     * ImageproxyURL constructor.
     * @param $imageproxyHost
     * @param $baseURL
     * @param $bucketName
     * @param $omitBaseURL
     */
    public function __construct($imageproxyHost, $baseURL, $bucketName, $omitBaseURL)
    {
        $this->imageproxyHost = rtrim($imageproxyHost, '/');
        $this->baseURL = rtrim($baseURL, '/');
        $this->bucketName = $bucketName;
        $this->omitBaseURL = $omitBaseURL;
    }

    public function generate($hashValue, Closure ... $optCallbacks)
    {
        $defaultOpt = new Option(null, null, null, null, 90);
        foreach ($optCallbacks as $optCallback) {
            $optCallback($defaultOpt);
        }
        $url = $this->imageproxyHost . '/' . $this->buildOptionStr($defaultOpt) . '/';
        if (!$this->omitBaseURL) {
            $url .= $this->baseURL . '/';
        }
        $url .= $this->bucketName . '/' . $hashValue;
        return $url;
    }

    protected function buildOptionStr(Option $opt)
    {
        $optionStr = '';
        if (!is_null($opt->getWidth())) {
            $optionStr .= $opt->getWidth() . 'x';
        } elseif (!is_null($opt->getWidthPercent())) {
            $optionStr .= $opt->getWidthPercent() . 'x';
        }

        if (!is_null($opt->getHeight())) {
            if ($optionStr == '') {
                $optionStr = 'x';
            }
            $optionStr .= $opt->getHeight();
        } elseif (!is_null($opt->getHeightPercent())) {
            if ($optionStr == '') {
                $optionStr = 'x';
            }
            $optionStr .= $opt->getHeightPercent();
        }

        if (is_numeric($opt->getQuality()) && $opt->getQuality() < 100) {
            if ($optionStr != '') {
                $optionStr .= ',';
            }
            $optionStr .= 'q' . $opt->getQuality();
        }
        return $optionStr;
    }

}
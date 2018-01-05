<?php


class WebcamList
{
    private $list = array();

    function __construct()
    {
        return true;
    }

    public function addWebcam(Webcam $webcam)
    {
        array_push($this->list,$webcam);
    }

    public function getWebcamArray(): array
    {
        return $this->list;
    }
}
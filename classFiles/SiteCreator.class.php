<?php

class SiteCreator
{
    private $__componentList = array();
    private $__menu = array();
    private $__anchor = array();
    private $__javascripts = array();
    private $__sectionNumber = 0;
    private $__siteDelivered = false;

    private $__permMap, $__permMessages, $__permWebcam, $__permWeather;



    function __construct()
    {
        if (isset($_GET["isValidated"])) {

            $db = DB::getInstance();

            $stm = $db->prepare("Select * from `permission` where `uri` = ?");
            $stm->bind_param("s", $_GET["isValidated"]);
            $stm->execute();

            $rst = $stm->get_result();

            $obj = $rst->fetch_object();

            $this->__permMap = $obj->perm_map;
            $this->__permMessages = $obj->perm_messages;
            $this->__permWeather = $obj->perm_weather;
            $this->__permWebcam = $obj->perm_webcam;


            if(!$this->__permMap and !$this->__permWebcam and !$this->__permWeather and !$this->__permMessages)
            {
                $this->accessDenied();
            }
        }
        else{
            $this->accessDenied();
        }

        $this->buildPage();

    }

    private function buildPage()
    {
        if($this->__permMap)
            $this->registerComponents(new MapComponent($this->__sectionNumber));

        if($this->__permWebcam)
            $this->registerComponents(new WebcamComponent($this->__sectionNumber));

        if($this->__permMessages)
            $this->registerComponents(new MessagesComponent($this->__sectionNumber));

        if($this->__permWeather)
            $this->registerComponents(new WeatherComponent($this->__sectionNumber));

    }

    public function getAnchors()
    {
        $setComma = false;
        $return =  "anchors: [";
        foreach ($this->__anchor as $anchor)
        {
            if($setComma)
            {
                $return .= ",'".$anchor."'";
            }
            else
            {
                $return .= "'".$anchor."'";
                $setComma = true;
            }
        }
        $return .= "],";

        return $return;

    }

    public function getMenu()
    {
        $return = "";
        for ($i = 0; $i < count($this->__anchor); $i++) {
            $return .= '<li data-menuanchor="' . $this->__anchor[$i] . '">
                            <a href="#' . $this->__anchor[$i] . '">' . $this->__menu[$i] . '</a></li>';
        }
        return $return;


    }

    private function registerJS(array $jsar)
    {
        foreach ($jsar as $path)
        {
            array_push($this->__javascripts, $path);
        }
    }

    public function neededJS()
    {
        $scriptTags ="";
        foreach ($this->__javascripts as $scriptPath)
        {
            $scriptTags .= '<script src="' . $scriptPath . '"></script>';
        }
        return $scriptTags;
    }

    private function accessDenied()
    {
        header('HTTP/1.0 403 Forbidden');
        echo "Forbidden!";
        exit();
    }

    public function getFullpage()
    {
        $page = "";

        foreach ($this->__componentList as $component)
        {
            $page .= $component->getDiv();
        }

        $this->__siteDelivered = true;
        return $page;
    }

    private function registerComponents(Component $component)
    {
        array_push($this->__componentList, $component);
        $this->registerJS($component->getNeededJS());
        $this->registerMenuAnchors($component->getMenuAnchors());
        $this->__sectionNumber++;
    }

    private function registerMenuAnchors(array $menuAnchor)
    {
        array_push($this->__menu,$menuAnchor[0]);
        array_push($this->__anchor,$menuAnchor[1]);
    }

}
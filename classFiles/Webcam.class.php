<?php

class Webcam
{

    private $title, $url;


    /**
     * Webcam constructor.
     * @param $title Ortsname, z.B. Zuoz, oder St. Moritz Clavadatsch
     * @param $url URL Der Webcam. Das Fragezeichen für die GET Parameter muss vorhanden sein! Da ein neues Bild anhand eines Timestamps abgerufen wird.
     *
     * @throws Exception
     */
    function __construct($title, $url)
    {
        if(strpos($url,"?") === False)
        {
            throw new Exception("Not '?' in URL! Please provide a GET paramater start sign.");
        }
        $this->title = $title;
        $this->url = $url;
    }

    public function getWebcamDiv()
    {
        return '<div class="slide" webcam="' . $this->title . '"><h2>' . $this->title . '</h2>
                    <img    src="' . $this->url . '"
                            realurl="' . $this->url . '"
                            alt="' . $this->title . '"
                            class="webcam"
                            title="Webcam ' . $this->title . '" />
                 </div>';
    }
}
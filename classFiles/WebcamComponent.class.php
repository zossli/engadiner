<?php


class WebcamComponent implements Component
{

    private $__sectionNumber, $__anchorName, $__title, $__webcamlist;

    /**
     * Component constructor.
     * local Vars =>
     * Minimal Constructor: $this->__sectionNumber = $sectionNumber;
     * @param int $sectionNumber
     */
    public function __construct(int $sectionNumber)
    {
        $this->__sectionNumber = $sectionNumber;
        $this->__anchorName = "webcam";
        $this->__title = "Webcam";

        $this->__webcamlist = new WebcamList();

        foreach (array(
                     "Zuoz Golf"=>"https://www.engadin-golf.ch/~webcam/zuoz.jpg?zuoz",
                     "Maloja" => "https://webcam.malojapalace.com/webcam-malojapalace.jpg?maloja",
                     "Sils Maria" => "https://backend.roundshot.com/cams/503f5b09b092de6121fba59a9c80ab75/default?sils",
                     "Samedan Flughafen" => "https://img.engadin.stmoritz.ch/object/63355/full.jpg?samedan"
                 ) as $title => $url)
        {
            $this->__webcamlist->addWebcam(new Webcam($title,$url));
        }
    }

    /**
     * Minimal: return '<div class="section" id="section' . $this->__sectionNumber . '">' .
     *                   $this->__content .
     *                 '</div>';
     * @return String Return the whole Section (DIV) for Fullpage Layout
     */
    public function getDiv(): String
    {
        $return =  '<div class="section" id="section' . $this->__sectionNumber . '">';
        foreach ($this->__webcamlist->getWebcamArray() as $webcam) {
            $return .= $webcam->getWebcamDiv();
        }
        $return .= '</div>';
        return($return);
    }



    /**
     * @return array Return an Array with all needed Javascript Paths
     */
    public function getNeededJS(): array
    {
        // TODO: Implement getNeededJS() method.
        return(array("/javascripts/webcams.js"));
    }

    /**
     * @return array Return array with (title, anchorName)
     */
    public function getMenuAnchors(): array
    {
        return(array($this->__title,$this->__anchorName));
    }
}

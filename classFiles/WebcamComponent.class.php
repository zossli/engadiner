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
                     "Zuoz" => "https://img.engadin.stmoritz.ch/object/137641/original.jpg?zuoz",
                     "Maloja" => "https://objects.estm.xiag.ch/file/?id=137640&maloja",
                     "St. Moritz - Clavadatsch" => "https://img.engadin.stmoritz.ch/object/69554/original.jpg?clava",
                     "Punt-Muragl" => "https://img.engadin.stmoritz.ch/object/52092/original.jpg?muragl"
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

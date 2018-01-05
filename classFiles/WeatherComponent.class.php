<?php

class WeatherComponent implements Component
{
    private $__sectionNumber, $__anchorName, $__title, $__content;

    /**
     * Component constructor.
     * local Vars =>     private $__sectionNumber, $__anchorName, $__title, $__content;
     * Minimal Constructor: $this->__sectionNumber = $sectionNumber;
     * @param int $sectionNumber
     */
    public function __construct(int $sectionNumber)
    {
        $this->__sectionNumber = $sectionNumber;
        $this->__anchorName = "weather";
        $this->__title = "Wetter";

    }

    /**
     * Minimal: return '<div class="section" id="section' . $this->__sectionNumber . '">' .
     *                   $this->__content .
     *                 '</div>';
     * @return String Return the whole Section (DIV) for Fullpage Layout
     */
    public function getDiv(): String
    {
        /**
         * http://www.meteoswiss.admin.ch/product/output/measured-values-v2/temperature/version__20170310_0853/de/SAM.json
         * http://www.meteoswiss.admin.ch/product/output/measured-values-v2/wind-combination/version__20170310_0852/de/SAM.json
         * http://www.meteoschweiz.admin.ch/product/output/measured-values-v2/wind-speed/version__20170310_0907/de/SAM.json
         * http://www.meteoschweiz.admin.ch/product/output/measured-values-v2/temperature/version__20170310_0907/de/SIA.json
         * http://www.meteoschweiz.admin.ch/product/output/measured-values-v2/wind-speed/version__20170310_0907/de/SIA.json
         */
        $return =  '<div class="section" id="section' . $this->__sectionNumber . '">';
        $return .= "Wetter";
        $return .= '</div>';
        return($return);    }

    /**
     * @return array Return an Array with all needed Javascript Paths
     */
    public function getNeededJS(): array
    {
        return(array(""));
    }

    /**
     * @return array Return array with (title, anchorName)
     */
    public function getMenuAnchors(): array
    {
        return(array($this->__title,$this->__anchorName));
    }
}
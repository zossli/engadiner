<?php


class MessagesComponent implements Component
{

    private $__sectionNumber, $__anchorName, $__title;

    /**
     * Component constructor.
     * local Vars =>
     * Minimal Constructor: $this->__sectionNumber = $sectionNumber;
     * @param int $sectionNumber
     */
    public function __construct(int $sectionNumber)
    {
        $this->__sectionNumber = $sectionNumber;
        $this->__anchorName = "messages";
        $this->__title = "Messages";


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
        $return .= "Messages";
        $return .= '</div>';
        return($return);
    }



    /**
     * @return array Return an Array with all needed Javascript Paths
     */
    public function getNeededJS(): array
    {
        // TODO: Implement getNeededJS() method.
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
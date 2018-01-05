<?php

interface Component
{
    /**
     * Component constructor.
     * local Vars =>     private $__sectionNumber, $__anchorName, $__title, $__content;
     * Minimal Constructor: $this->__sectionNumber = $sectionNumber;
     * @param int $sectionNumber
     */
    function __construct(int $sectionNumber);

    /**
     * Minimal: return '<div class="section" id="section' . $this->__sectionNumber . '">' .
     *                   $this->__content .
     *                 '</div>';
     * @return String Return the whole Section (DIV) for Fullpage Layout
     */
    public function getDiv():String;

    /**
     * @return array Return an Array with all needed Javascript Paths
     */
    public function getNeededJS():array;

    /**
     * @return array Return array with (title, anchorName)
     */
    public function getMenuAnchors():array;

 

}
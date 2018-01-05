<?php

class MapComponent implements Component
{
    private $__sectionNumber, $__anchorName, $__title, $__content;

    private $SVGOBJECTS = "";
    private $color = array(
        "#FF0000",
        "#0000FF",
        "#00FF00",
        "#FFFF00",
        "FF00FF");
    private $legenBoxPos = array(
        20,
        20);

    /**
     * Component constructor.
     * local Vars =>     private $__sectionNumber, $__anchorName, $__title, $__content;
     * Minimal Constructor: $this->__sectionNumber = $sectionNumber;
     * @param int $sectionNumber
     */
    public function __construct(int $sectionNumber)
    {
        $this->__sectionNumber = $sectionNumber;
        $this->__anchorName = "map";
        $this->__title = "Karte";

        $db = DB::getInstance();

        $stm = $db->prepare("
                            Select d.name as name, p.map_only, map_only, uniqueid 
                              from perm_dev as pd 
                              inner join devices as d on pd.`device_id` = d.`id` 
                              inner join positions as pos on pos.id = d.`positionid` 
                              inner join `permission` as p on p.`uri`= pd.`uri` 
                            where p.`uri` = ?");

        $stm->bind_param("s", $_GET["isValidated"]);
        $stm->execute();

        $rst = $stm->get_result();

        $circlestemp = "";
        $i = 0;

        while ($obj = $rst->fetch_object()) {
            $circlestemp .= '<circle class="circleclasses mapclick" 
                                     uuid="' . $obj->uniqueid . '" 
                                     id = "circle_' . $obj->uniqueid . '" 
                                     cx = "00px" 
                                     cy = "00px" 
                                     r = "6" 
                                     stroke = "black" 
                                     stroke-width = "1" 
                                     fill = "' . $this->color[$i] . '" />';

            $circlestemp .= '<circle class="legend circleclasses mapclick" 
                                     uuid="' . $obj->uniqueid . '" 
                                     id = "legend_' . $obj->uniqueid . '" 
                                     cx = "' . ($this->legenBoxPos[0] + 10) . 'px" 
                                     cy = "' . ($this->legenBoxPos[1] + 10 + 18 * $i) . 'px" 
                                     r = "5" 
                                     stroke = "black" 
                                     stroke-width = "1" 
                                     fill = "' . $this->color[$i] . '" />';

            $circlestemp .= '<text  class="legend mapclick" 
                                    uuid="' . $obj->uniqueid . '" 
                                    id="legend_text_' . $obj->uniqueid . '" 
                                    x = "' . ($this->legenBoxPos[0] + 20) . 'px" 
                                    y = "' . ($this->legenBoxPos[1] + 15 + 18 * $i) . 'px">' . "</text>";
            $i++;

        }
        $this->SVGOBJECTS = '<rect  id="reglegendonoff" 
                                            class="legendclick" 
                                            x="4" 
                                            y="0" 
                                            height="23px" 
                                            width="220px" 
                                            z-index="-10" 
                                            stroke="black" 
                                            stroke-width="1px" 
                                            fill="white">
                                      </rect>
                                      <text x="8" 
                                            y="10" 
                                            class="legendclick" 
                                            id="legendonoff">Legende ein und ausblenden
                                      </text>
                                      <rect id="rectangle" 
                                            class="legend" 
                                            x="' . $this->legenBoxPos[0] . '" 
                                            y="' . $this->legenBoxPos[1] . '" 
                                            width="140px" 
                                            height="' . ((18 * $i - 1) + 5) . 'px" 
                                            z-index="-10" 
                                            stroke="black" 
                                            stroke-width="1px" 
                                            fill="white"/>'
            . $circlestemp;

    }

    /**
     * Minimal: return '<div class="section" id="section' . $this->__sectionNumber . '">' .
     *                   $this->__content .
     *                 '</div>';
     * @return String Return the whole Section (DIV) for Fullpage Layout
     */
    public function getDiv(): String
    {
        $val = '<div class="section" id="section' . $this->__sectionNumber . '">';
        $val .= '<svg class="mapoverview"  id="svg-span">';
        $val .= $this->SVGOBJECTS;
        $val .= '</svg></div>';
        return $val;
    }

    /**
     * @return array Return an Array with all needed Javascript Paths
     */
    public function getNeededJS(): array
    {
        return(array("/javascripts/locations.js", "/javascripts/wgs84_ch1903.js"));
    }

    /**
     * @return array Return array with (title, anchorName)
     */
    public function getMenuAnchors(): array
    {
        return(array($this->__title,$this->__anchorName));
    }



}
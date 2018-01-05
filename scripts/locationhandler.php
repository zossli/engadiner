<?php
include "../config/config.php";

header("Content-Type:text/xml");

$db = DB::getInstance();
$stm = $db -> prepare("SELECT latitude, longitude, UNIX_TIMESTAMP(fixtime) as time, name, uniqueid FROM devices as d INNER JOIN positions as p on deviceid = d.id WHERE d.positionid = p.id");
$stm -> execute();
$rst = $stm -> get_result();

$line = "<competitors>";

    while ($obj = $rst->fetch_object())
    {
        $time = $obj->time;
        $line.="<competitor><name>";
        $line.=$obj->name;
        $line.="</name> <unique>";
        $line.=$obj->uniqueid;
        $line.="</unique><latitude>";
        $line.=$obj->latitude;
        $line.="</latitude><longitude>";
        $line.=$obj->longitude;
        $line.="</longitude><time>";
        if ((time() - $time) > (24*3600))
        {
            $line .= "(aktualisiert am ".date("d.m.Y",$time).")";
        }
        elseif ((time() - $time) > (60 * 5))
        {
            $line .= "(aktualisiert um ".date("G:i.s",$time)." Uhr)";
        }
        else
        {
            $seconds = (time() - $time);
            if($seconds>59)
            {
                $line .= "(aktualisiert vor " . 1*date('i',$seconds)."min ". 1*date('s',$seconds)."s" . " Sekunden)";
            }
            else
            {
                $line .= "(aktualisiert vor " . $seconds . " Sekunden)";
            }
        }
        $line.="</time>
        </competitor>";
    }

$line.="</competitors>";
echo $line;



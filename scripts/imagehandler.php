<?php

include("../classFiles/DB.class.php");
header("Content-Type:text/xml");

if(isset($_POST["received_id"]) AND isset($_POST["isValidated"]))
{
    if($_POST["received_id"]!="" AND $_POST["isValidated"]!="")
    {
        $db = DB::getInstance();
        $stm = $db -> prepare("Select i.from as 'from',
                                      UNIX_TIMESTAMP(i.time) as 'time',
                                      i.image as 'image',
                                      i.id as 'id',
                                      i.description as 'text'
                              from images as i
                              where i.id > ? and i.id in (SELECT image_id FROM perm_images
                                                  WHERE uri = ?)");
        $stm -> bind_param("is", $_POST["received_id"], $_POST["isValidated"]);
        $stm -> execute();
        $rst = $stm -> get_result();
        $line = "<images>";

        while ($obj = $rst->fetch_object())
        {
            $time = $obj->time;
            $line.="<image><from>";
            $line.=$obj->from;
            $line.="</from> <text>";
            $line.=$obj->message;
            $line.="</text><id>";
            $line.=$obj->id;
            $line.="</id><time>";
            $line.= date("H:i.s d.m.Y",$obj->time);
            $line.="</time></image>";
        }

        $line.="</images>";
        echo $line;

    }
}
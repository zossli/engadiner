<?php

include("../classFiles/DB.class.php");
header("Content-Type:text/xml");

if(isset($_POST["received_id"]) AND isset($_POST["isValidated"]))
{
    if($_POST["received_id"]!="" AND $_POST["isValidated"]!="")
    {
        $db = DB::getInstance();
        $stm = $db -> prepare("Select m.from as 'from',
                                      UNIX_TIMESTAMP(m.time) as 'time',
                                      m.message as 'message',
                                      m.id as 'id'
                              from messages as m
                              where m.id > ? and m.id in (SELECT message_id FROM perm_messages
                                                  WHERE uri = ?)");
        $stm -> bind_param("is", $_POST["received_id"], $_POST["isValidated"]);
        $stm -> execute();
        $rst = $stm -> get_result();
        $line = "<messages>";

        while ($obj = $rst->fetch_object())
        {
            $time = $obj->time;
            $line.="<message><from>";
            $line.=$obj->from;
            $line.="</from> <text>";
            $line.=$obj->message;
            $line.="</text><id>";
            $line.=$obj->id;
            $line.="</id><time>";
            $line.= date("d.m.Y H:i.s",$obj->time);
            $line.="</time></message>";
        }

        $line.="</messages>";
        echo $line;

    }
}
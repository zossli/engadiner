<?php
include_once "../config/config.php";
$hostname = MAILHOST;
$username = MAILUSERNAME;
$password = MAILPASSWORD;



function umlaute($string) {
    $search = array(
        "Ä",
        "Ö",
        "Ü",
        "ä",
        "ö",
        "ü",
        "ß",
        "´");
    $replace = array(
        "&Auml;",
        "&Ouml;",
        "&Uuml;",
        "&auml;",
        "&ouml;",
        "&ueml;",
        "ss",
        "");
    return str_replace($search, $replace, $string);
}

/* try to connect */
$inbox = imap_open($hostname, $username, $password) or die('Cannot connect to ImapServer: ' . imap_last_error());

$emails = imap_search($inbox, 'ALL');


$filename = 0;

//echo "<p>";

/* if emails are returned, cycle through each... */
if ($emails)
{

    /* begin output var */
    $output = '';


    /* put the newest emails on top */
    rsort($emails);

    foreach ($emails as $email_number)
    {

        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox, $email_number, 0);
        //$message = imap_fetchbody($inbox, $email_number, 2);
        $structure = imap_fetchstructure($inbox, $email_number);
    print_r($structure);

        $time = strtotime($overview[0]->date);
        if (isset($overview[0]->subject))
        {
            $text = " ";
            $i = 0;
            while (isset(imap_mime_header_decode($overview[0]->subject)[$i]))
            {
                $text .= htmlentities(imap_mime_header_decode($overview[0]->subject)[$i]->text, ENT_COMPAT, imap_mime_header_decode($overview[0]->subject)[$i]->charset);
                $i++;
            }
        }
        else
        {
            $text = " ";
        }
        $from = $overview[0]->from;

        $attachments = array();
        if (isset($structure->parts) && count($structure->parts))
        {
            for ($i = 0; $i < count($structure->parts); $i++)
            {
                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => '');



                // pre($structure->parts[$i]);
                if ($structure->parts[$i]->ifdparameters)
                {
                    foreach ($structure->parts[$i]->dparameters as $object)
                    {
                        if (strtolower($object->attribute) == 'filename')
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if ($structure->parts[$i]->ifparameters)
                {
                    foreach ($structure->parts[$i]->parameters as $object)
                    {
                        if (strtolower($object->attribute) == 'name')
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }



                if ($attachments[$i]['is_attachment'])
                {
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i + 1);
                    if ($structure->parts[$i]->encoding == 3)
                    { // 3 = BASE64
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    elseif ($structure->parts[$i]->encoding == 4)
                    { // 4 = QUOTED-PRINTABLE
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            } // for($i = 0; $i < count($structure->parts); $i++)
        } // if(isset($structure->parts) && count($structure->parts))




        if (count($attachments) != 0)
        {
            $first = true;
            $query = "";
            foreach ($attachments as $at)
            {

                if ($at["is_attachment"] == 1)
                {
                    $fname = str_replace(".", "", microtime(true));
                    $ending = explode(".", $at["filename"]);

                    if (!$first)
                    {
                        $query .= ", ";
                    }
                    //$query .= "(NULL, '" . $fname . "." . end($ending) . "', '" . $from . "', '" . $text . "')";
                    //file_put_contents("../liveImages/" . $fname . "." . end($ending), $at["attachment"]);
                    $first = false;
                }
            }
            if (!$first)
            {
                /*$stmt = $mysqli->prepare("INSERT INTO `zossliz_traccar`.`images` (`id`, `image`, `from`, `text`) VALUES " . $query . ";");
                $stmt->execute();
                $stmt->close();*/
            }
        }
        //imap_delete($inbox, $email_number);
        if ($text != "")
        {
           /* $query = "INSERT INTO `zossliz_traccar`.`texts` (`time`, `text`, `from`) VALUES ('" . $time . "', '" . $text . "', '" . $from . "');";
            $stmt = $mysqli->prepare($query);
            $stmt->execute();
            $stmt->close();*/
        }

        //print_r($GLOBALS);
        //echo "<br />";
    }

// echo $output;
}


//echo "</p>";

/* close the connection */
//imap_expunge($inbox);
imap_close($inbox);


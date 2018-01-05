<?php
include "../config/config.php";
switch($_POST["submit"]){
    case "Nachricht senden.":
        if(isset($_POST["message"]) AND isset($_COOKIE["admin"])) {
            $cookie = (unserialize(base64_decode($_COOKIE["admin"])));
            if ($_POST["message"]!="" AND $cookie["name"]!="") {
                $db = DB::getInstance();
                $stm = $db->prepare("INSERT INTO `messages` (`message`, `from`, `time`) VALUES (?,?,FROM_UNIXTIME(?))");
                $stm->bind_param("ssi", $_POST["message"], $cookie["name"], time());
                $stm->execute();
                $id = $stm->insert_id;
            }
            $stm = $db->prepare("INSERT INTO `perm_messages` (`uri`, `message_id`) VALUES (?,?)");
            foreach($_POST["permission"] as $perm)
            {
                $stm->bind_param("si", $perm, $id);
                $stm->execute();
            }
        }
        break;

    case "Foto speichern.":
        if(isset($_FILES["photo"]) AND isset($_COOKIE["admin"]) AND isset($_POST["nachricht"])) {
            $cookie = (unserialize(base64_decode($_COOKIE["admin"])));
            if ($_FILES["photo"]["tmp_name"]!="" AND $cookie["name"]!="" AND $_POST["nachricht"]!="") {
                $picture = file_get_contents($_FILES["photo"]["tmp_name"]);
                
                $db = DB::getInstance();
                $stm = $db->prepare("INSERT INTO `images` (`image`, `from`, `time`, `description`) VALUES (?,?,FROM_UNIXTIME(?),?)");
                $stm->bind_param("ssis", $picture, $cookie["name"], time(), $_POST["nachricht"]);
                $stm->execute();
                $id = $stm->insert_id;
            }
            $stm = $db->prepare("INSERT INTO `perm_images` (`uri`, `image_id`) VALUES (?,?)");
            foreach($_POST["permission"] as $perm)
            {
	            echo $perm;
	            echo "<br />";
                $stm->bind_param("si", $perm, $id);
                $stm->execute();
            }
        }
        break;

    default:
        break;
}

//header("Location:/admin/index.php");
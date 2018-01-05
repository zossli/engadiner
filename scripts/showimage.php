<?php


include("../classFiles/DB.class.php");
if(isset($_GET["img_id"]) AND isset($_GET["isValidated"])) {
    if ($_GET["img_id"] != "" AND $_GET["isValidated"] != "") {
        $db = DB::getInstance();
        $stm = $db -> prepare("Select i.image as 'image'
                                      from images as i
                                      inner join perm_images as pi on i.id = pi.image_id
                              where i.id = ? and pi.uri = ?");
        $stm -> bind_param("is", $_GET["img_id"], $_GET["isValidated"]);
        $stm -> execute();
        $rst = $stm -> get_result();
        $obj = $rst -> fetch_object();
        header("Content-Type: image");
        $src = $obj->image;
        $img = imagecreatefromstring($src);
        // Rotate

        if ($exif = @exif_read_data("data://;base64," . base64_encode($src))) {
            $ort = $exif['Orientation'];
            switch($ort) {

                case 3 :
                    // 180 rotate left
                    $img = imagerotate($img, 180, 0);
                    break;

                case 6 :
                    // 90 rotate right
                    $img = imagerotate($img, -90, 0);
                    break;

                case 8 :
                    // 90 rotate left
                    $img = imagerotate($img, 90, 0);
                    break;
            }

            imagejpeg($img);

        } else {
            echo $src;
        }

    }
}
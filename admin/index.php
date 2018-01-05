<?
include "../config/config.php";
if(isset($_POST["name"]) and isset($_POST["email"]))
{
    setcookie("admin", base64_encode(serialize(array("name"=>$_POST["name"], "email"=>$_POST["email"]))),time()+(3600*990));
}
else if(!isset($_COOKIE["admin"]))
{
    echo "Bitte Name und Mail angeben.";
    echo "<form method=\"post\" action=\"index.php\">
            Name: <input type=\"text\" name=\"name\" /><br />
            eMail: <input type=\"email\" name=\"email\" />
            <input type='submit'>
        </form> ";
    exit();
}

?><!DOCTYPE html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
<h1>Admin-Bereich</h1><form enctype="multipart/form-data" action="upload.php" method="post">
<section>
    <div>
        <?php
        $db = DB::getInstance();
        $stm = $db->prepare("SELECT * FROM `permission` WHERE not map_only");
        $stm->execute();
        $rst = $stm->get_result();
        echo "<fieldset><legend><h2>Wer darf es sehen:</h2></legend>";
        while ($obj = $rst->fetch_object()) {
            echo('<input type="checkbox" name="permission[]" value="' . $obj->uri . '">' . $obj->name . "<br />");
        }
        echo "</fieldset>";

        ?>
    </div>
    <div>
            <fieldset>
                <legend><h2>Bild upload:</h2></legend>
                <label>
                    <span>Bild:</span><br /><input id="photo" type="file" name="photo"/>
                </label>
                <br/>
                <label>
                    <span>Text</span><br/>
                    <input id="text" type="text" style="width: 100%;" name="nachricht" />
                </label>
                <br/>
                <input type="submit" id="submitfoto" name="submit" value="Foto speichern."/>
            </fieldset>
    </div>

</section></form>
</body>
</html>
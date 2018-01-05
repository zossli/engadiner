<?php
define('ABSPATH', $_SERVER["DOCUMENT_ROOT"]."");


 define("DBHOST", "");
 define("DBUSER", "");
 define("DBUSERPW", "");
 define("DBDATABASE", "");

define('MAILHOST','{}INBOX');
define('MAILUSERNAME','');
define('MAILPASSWORD', '');

function getcurrenturi()
{
 $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
 $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
 if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
 $uri = trim($uri, '/');
 $uri = explode("/",$uri);
 return $uri;
}

spl_autoload_register(function ($class_name) {
 $file = ABSPATH . "/classFiles/" . $class_name . '.class.php';
 if (file_exists($file)) {
  include $file;
  return true;
 }
 return false;
});

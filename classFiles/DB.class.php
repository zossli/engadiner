<?php

class DB extends mysqli {
	
    static private $instance;

    public function __construct() {
        include_once("../config/config.php");
        parent::__construct(DBHOST, DBUSER, DBUSERPW, DBDATABASE);
    }

    static public function getInstance() {
        if (!self::$instance)
        {
            @self::$instance = new DB();
            if (self::$instance->connect_errno > 0)
                die("Unable to connect to database [" . self::$instance->connect_error . "]");
        }
        return self::$instance;
    }

    static public function doQuery($sql) {
        return self::getInstance()->query($sql);
    }
    

}


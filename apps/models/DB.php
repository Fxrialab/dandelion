<?php
require_once(dirname(dirname(__FILE__)) . "/config/Structure.php");
require_once(CONFIG . 'Database.php');
require_once(ORIENTDB . "OrientDB.php");

function getDBConnection()
{
    static $db = null;

    if (!is_object($db)) {
        $db = new OrientDB(HOST, PORT) or die('Failed to connect');
    }
    return $db;
}

?>
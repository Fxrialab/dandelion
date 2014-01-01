<?php
require_once ('db.php');

$db = &getDBConnection();
$db->DBOpen(DATABASE, USER, PASSWORD);

$existFile = MODELS."existedClass.php";

$sql = array(
    "Create class user extends V"       => "user",
    "Create class notify"               => "notify",
    "Create class sessions"             => "sessions",
    "Create class status"               => "status",
    "Create class comment"              => "comment",
    "Create class activity"             => "activity",
    "Create class actions"              => "actions",
    "Create class friendship extends E" => "friendship",
    "Create class follow"               => "follow",
    "Create class album"                => "album",
    "Create class photo"                => "photo",
    "Create class information"          => "information",
    "Create class permission"           => "permission",
    "Create class like"                 => "like",
);

if (!file_exists($existFile))
{
    $fb = fopen(MODELS."existedClass.php", "wb");

    foreach ($sql as $command=>$class)
    {
        fwrite($fb, $class.'_');
        $db->command(OrientDB::COMMAND_QUERY, $command);
    }
    fclose($fb);
}else {
    $file           = file_get_contents($existFile);
    $existedClass   =  explode('_', substr($file,0,strlen($file)-1));
    $differences    = array_diff($sql, $existedClass);
    if (count($differences) > 0)
    {
        $fb = fopen(MODELS."existedClass.php", "wb");
        foreach ($differences as $command=>$class)
        {
            fwrite($fb, $class.'_');
            $db->command(OrientDB::COMMAND_QUERY, $command);
        }
        fclose($fb);
    }
}
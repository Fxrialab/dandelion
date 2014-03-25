<?php

class OrientDBConfig
{
    static private $map;
    static public function mapClass($className)
    {
        require_once CONFIG."orientDBCC.php";

        foreach ($collectionDefaults as $coll=>$details)
        {
            if ($coll == $className)
            {
                OrientDBConfig::$map = array('className'=>$details['className'], 'clusterID'=>$details['clusterID']);
            }
        }

        return OrientDBConfig::$map;
    }
}
<?php
require_once SERVICE_UTILS . "impl/Key.php";

class Service
{
    public static function execute($exchangeName, $exchangeType)
    {
        $impl = new Key();
        $impl->setChannel($exchangeName, $exchangeType);
        return $impl;
    }
}
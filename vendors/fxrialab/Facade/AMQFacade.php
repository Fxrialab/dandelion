<?php
require_once SERVICE_UTILS . "impl/Service.php";
class AMQFacade
{
    public function exchange($exchangeName, $exchangeType)
    {
        return Service::execute($exchangeName, $exchangeType);
    }
}
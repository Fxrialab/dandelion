<?php
require_once SERVICE_UTILS . "impl/Notifications.php";
class Key
{
    protected $exchangeName;
    protected $exchangeType;

    public function setChannel($exchangeName, $exchangeType)
    {
        $this->exchangeName = $exchangeName;
        $this->exchangeType = $exchangeType;
    }

    public function routingKey($routingKey)
    {
        $impl = new Notifications();
        $impl->setTarget($this->exchangeName, $this->exchangeType, $routingKey);
        return $impl;
    }
}
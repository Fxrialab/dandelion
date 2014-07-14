<?php
require_once SERVICE_UTILS . "impl/AMQP.php";
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
        $impl = new AMQP();
        $impl->setTarget($this->exchangeName, $this->exchangeType, $routingKey);
        return $impl;
    }
}
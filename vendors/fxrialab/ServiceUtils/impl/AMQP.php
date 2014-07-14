<?php
require_once CONFIG . 'AmqpConfig.php';
require_once AMQP . 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQP
{
    protected $exchangeName;
    protected $exchangeType;
    protected $routingKey;
    protected $msgs;

    public function setTarget($exchangeName, $exchangeType, $routingKey)
    {
        $this->exchangeName = $exchangeName;
        $this->exchangeType = $exchangeType;
        $this->routingKey   = $routingKey;
    }

    public function dispatch($action, $data)
    {
        $connection = new AMQPConnection(AMQP_HOST, AMQP_POST, AMQP_USER, AMQP_PASSWORD);
        $channel    = $connection->channel();

        $channel->exchange_declare($this->exchangeName, $this->exchangeType, false, false, false);

        $msg = new AMQPMessage(json_encode($data), array('content_type' => 'application/json'));
        $channel->basic_publish($msg, $this->exchangeName, $this->routingKey);
        $channel->close();
        $connection->close();
    }
}
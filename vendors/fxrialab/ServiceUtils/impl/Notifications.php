<?php
require_once CONFIG . 'AmqpConfig.php';
require_once AMQP . 'vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Notifications
{
    protected $exchangeName;
    protected $exchangeType;
    protected $routingKey;

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

        $msg = new AMQPMessage($data);
        $channel->basic_publish($msg, $this->exchangeName, $this->routingKey);
        $channel->close();
        $connection->close();

        $text = $this->exchangeName.' is dispatch '.$action.' with key: '.$this->routingKey;

        return $text;
    }

    public function listen($action)
    {
        $connection = new AMQPConnection(AMQP_HOST, AMQP_POST, AMQP_USER, AMQP_PASSWORD);
        $channel    = $connection->channel();

        $channel->exchange_declare($this->exchangeName, $this->exchangeType, false, false, false);
        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);
        //echo $this->routingKey;
        $channel->queue_bind($queue_name, $this->exchangeName, $this->routingKey);
        /*foreach($this->routingKey as $binding_key) {
            $channel->queue_bind($queue_name, $this->exchangeName, $binding_key);
        }*/
        echo $queue_name;
        $callback = function($msg){
            echo ' [x] ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
        };
        //$data = '';
        $test = $channel->basic_consume($queue_name, '', false, true, false, false, $callback);
        //var_dump($data);
        /*while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();*/
        $text = $this->exchangeName.' is listen '.$action;
        return $callback;
    }
}
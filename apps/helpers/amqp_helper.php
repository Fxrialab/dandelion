<?php
//@todo: test and debug 
require_once(SYMFONY_LOADER . 'UniversalClassLoader.php');
//echo SYMFONY_LOADER . 'UniversalClassLoader.php';
/**
 * Symphony Loader for php amqp
 */

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
            'PhpAmqpLib' => VENDORS
        ));
$loader->register();

require_once (CONFIG . 'database.php');
require_once(CONFIG . 'rabbitmq.php');

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpHelper {
	public function __construct() {		
	}
	
	public function notify($actor) {		
		// send to message queue
		$conn = new AMQPConnection(HOST, AMQP_PORT, AMQP_USER, AMQP_PASS, VHOST);
		$ch = $conn->channel();
			
		$routing_key = str_replace('@', ' ', $actor->data->email);
		//$routing_key = "gtdminh81.gmail.com";
		// add message body here
		$msg_body = '{"value":"success"}';
		$msg = new AMQPMessage($msg_body, array('priority'=>0, 'delivery-mode' => 2));
		$ch->basic_publish($msg, 'activities', $routing_key);
		
		$ch->close();
		$conn->close();
	}
}
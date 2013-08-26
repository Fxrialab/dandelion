<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 9:03 AM
 * Project: UserWired Network - Version: beta
 */
require_once(AMQCONFIG.'autoload.php');

define('HOST_AMQ', 'localhost');
define('PORT_AMQ', 5672);
define('USER_AMQ', 'guest');
define('PASS_AMQ', 'guest');
define('VHOST_AMQ', '/');

//If this is enabled you can see AMQP output on the CLI
define('AMQP_DEBUG', true);

?>
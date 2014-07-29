<?php

require_once CONTROLLERS . "Controller.php";

class NotificationElement extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getNotificationElement()
    {
        $this->renderPartial('elements/notification');
    }

}

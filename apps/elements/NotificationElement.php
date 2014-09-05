<?php
class NotificationElement extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getNotificationElement()
    {
        $this->render('elements/notificationPopUpOver.php','default');
    }

}

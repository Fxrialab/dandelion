<?php
class MessageElement extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getMessageElement()
    {
        $this->render('elements/messagePopUpOver');
    }

}

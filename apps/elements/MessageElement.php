<?php

require_once CONTROLLERS . "Controller.php";

class MessageElement extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getMessageElement()
    {
        $this->renderPartial('elements/message');
    }

}

<?php

require_once CONTROLLERS . "Controller.php";

class FriendRequestElement extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getFriendRequestElement()
    {
        $this->renderPartial('elements/friendRequest');
    }

}

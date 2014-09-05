<?php
class FriendRequestElement extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getFriendRequestElement()
    {
        $this->render('elements/friendRequestPopUpOver.php', 'default');
    }

}

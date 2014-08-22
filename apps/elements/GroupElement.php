<?php

require_once CONTROLLERS . "Controller.php";

class GroupElement extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getGroupElement()
    {
        $groupMember = $this->facade->findAllAttributes('groupMember', array('member' => F3::get('SESSION.userID')));
        $this->renderPartial('elements/group', array('groupMember' => $groupMember));
    }

}

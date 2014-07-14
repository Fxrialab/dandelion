<?php

class ListController extends AppController
{

    public function __construct() {
        parent::__construct();
    }

    //has implement and fix logic
    public function viewPost($entry, $key)
    {
        if (!empty($entry))
        {
            $currentUser= $this->getCurrentUser();
            $statusRC   = $this->facade->findByAttributes('status', array('@rid'=>'#'.$entry->data->object, 'active'=>1));

            $activityID = $entry->recordID;
            $userID = $this->f3->get('SESSION.userID');

            if (!empty($statusRC))
            {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $this->facade->findByPk("user", $statusRC->data->owner);

                $like = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID,'objID'=>$statusID));
                $entry = array(
                    'type'      => 'post',
                    'key'       => $key,
                    'like'      => $like,
                    'username'  => $userRC->data->username,
                    'avatar'    => $userRC->data->profilePic,
                    'userID'      => $userRC,
                    'actions'   => $statusRC,
                    'statusID'  => $statusID,
                    'path'      => Register::getPathModule('post'),
                );
                return $entry;
            }else{
                return false;
            }

        }
    }

}

?>

<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 3:23 PM
 * Project: UserWired Network - Version: beta
 */
class ElementController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    static public function head()
    {
        return '123';
    }

//    public function profileElement()
//    {
//        $currentUser = $this->getCurrentUser();
//        $getProfile = $this->User->findOne("@rid = ?", array("#" . $currentUser->recordID));
//        F3::set('profile', $getProfile);
//    }

//    public function header()
//    {
//        $currentUser = $this->getCurrentUser();
//        F3::set('queueAmq', $currentUser->recordID);
//        //********** Notifications for request friend, follow and comment post status or question & answer *******************//
//        //With request friend
//        $findRequestToUser = $this->Friendship->findByCondition("userB = ? AND relationship = 'request' AND status = 'new' LIMIT 5 ORDER BY published DESC", array($currentUser->recordID));
//        if ($findRequestToUser)
//        {
//            foreach ($findRequestToUser as $requestToUser)
//            {
//                $findPeopleRequestTo[($requestToUser->data->userA)] = $this->User->findByCondition("@rid = ? LIMIT 5", array('#' . $requestToUser->data->userA));
//            }
//            F3::set('ListRecordRequestTo', $findRequestToUser);
//            F3::set('ListPeopleRequestTo', $findPeopleRequestTo);
//        }
//        //With follow
//        //@todo: group follow when most people follow one content
//
//        /* get notify in load page */
//        $getNotify = $this->Notify->findByCondition("userID = ? ", array($currentUser->recordID));
//        F3::set('countNotify', $getNotify);
//        //Who comment to your post
//        $allComment = $this->Activity->findByCondition('owner = ? LIMIT 10 ORDER BY published DESC', array($currentUser->recordID));
//        if ($allComment)
//        {
//            $resultComments = array();
//            foreach ($allComment as $oneComment)
//            {
//                $modulesType = substr($oneComment->data->verb, 0, strpos($oneComment->data->verb, $oneComment->data->object)) . 'controller';
//                foreach (glob(MODULES . '*/controllers/' . $modulesType . '.php') as $modulesFileControl)
//                {
//                    if (file_exists($modulesFileControl))
//                    {
//                        $modController = new $modulesType;
//                        if (method_exists($modController, 'LoadComment'))
//                        {
//                            $resultComment = $modController->LoadComment($oneComment->data->object, $oneComment->data->actor, $oneComment->recordID);
//                            array_push($resultComments, $resultComment);
//                        }
//                    }
//                }
//            }
//            F3::set('allComment', $resultComments);
//        }
//    }

    /* public function peopleYouMayKnowElement()
      {

      } */
}
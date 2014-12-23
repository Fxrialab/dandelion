<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CommentController extends AppController
{

    public function comment($typeID, $type, $content)
    {

        $currentUser = $this->getCurrentUser();
        $published = time();
        //target for count who comments to post on notification, will check later
        $commentEntryCase = array(
            "owner" => $currentUser->recordID,
            "content" => $content,
            "typeID" => str_replace('_', ':', $typeID),
            "published" => $published,
            'numberLike' => 0
        );
        $commentID = $this->facade->save('comment', $commentEntryCase);
        $commentRC = $this->facade->findByPk('comment', $commentID);
        /* Update number comment */
        $status_update = $this->facade->findByAttributes($type, array('@rid' => '#' . str_replace('_', ':', $typeID)));
        $dataCountNumberComment = array(
            'numberComment' => $status_update->data->numberComment + 1
        );
        $this->facade->updateByAttributes($type, $dataCountNumberComment, array('@rid' => "#" . str_replace('_', ':', $typeID)));
        //sent a notifications to owner's status
        $owner = $status_update->data->owner;
//        $duplicate = $this->facade->findByAttributes('activity', array('owner' => $owner, 'verb' => 'comment', 'object' => str_replace('_', ':', $typeID)));
//        if (empty($duplicate))
//        {
        //create a activity for owner's status
        $entry = array(
            'owner' => $owner,
            'actor' => $currentUser->recordID,
            'verb' => 'comment',
            'object' => $this->getRecordId($typeID),
            'type' => 'notifications',
            'published' => $published,
            'details' => 'commented on your status',
        );
        $this->facade->save('activity', $entry);
        //update to notify class
        $curNotify = $this->facade->findByAttributes('notify', array('userID' => $owner));
        $updateNotify = array(
            'notifications' => $curNotify->data->notifications + 1,
        );
        $this->facade->updateByAttributes('notify', $updateNotify, array('userID' => $owner));
        //sent a notifications
        $newNotify = $this->facade->findByAttributes('notify', array('userID' => $owner));
        $notifications = $newNotify->data->notifications;
        $keys = 'notifications.comment.' . $owner;
        $keys = str_replace(':', '_', $keys);
//            $data = array(
//                'type' => 'comment',
//                'target' => str_replace(':', '_', $postID),
//                'dispatch' => str_replace(':', '_', $currentUser->recordID),
//                'content' => $content,
//                'published' => $published,
//                'count' => $notifications,
//            );
//            $this->service->exchange('dandelion', 'topic')->routingKey($keys)->dispatch('comment', $data);
//        }
//        else
//        {//else update it
//            $actor = explode('_', $duplicate->data->actor);
//            $pos = array_search($currentUser->recordID, $actor);
//            if (!is_bool($pos))
//            {
//                unset($actor[$pos]);
//            }
//            $str = '';
//            if (count($actor) >= 1)
//            {
//                foreach ($actor as $actors)
//                {
//                    $str = $str . $actors . '_';
//                }
//                $str = substr($currentUser->recordID . '_' . $str, 0, -1);
//            }
//            elseif (count($actor) == 0)
//            {
//                $str = $str . $currentUser->recordID;
//            }
//            //then create a activity for who's friend join to status
//            $curActor = explode('_', $duplicate->data->actor);
//            $ownerName = HelperController::getFullNameUser($owner);
//            foreach ($curActor as $a)
//            {
//                if ($a != $currentUser->recordID)
//                {
//                    $actorActivity = $this->facade->findByAttributes('activity', array('owner' => $a, 'verb' => 'comment', 'object' => $postID));
//                    if (empty($actorActivity))
//                    {
//                        $entry = array(
//                            'owner' => $a,
//                            'actor' => $str,
//                            'verb' => 'comment',
//                            'object' => $postID,
//                            'type' => 'notifications',
//                            'timers' => $published,
//                            'details' => "also commented on " . $ownerName . "'s status",
//                        );
//                        $this->facade->save('activity', $entry);
//                    }
//                    else
//                    {
//                        $actorActivity->data->actor = $str;
//                        $actorActivity->data->timers = $published;
//                        $this->facade->updateByPk('activity', $actorActivity->recordID, $actorActivity);
//                    }
//                    //update to notify class
//                    $curNotify = $this->facade->findByAttributes('notify', array('userID' => $a));
//                    $updateNotify = array(
//                        'notifications' => $curNotify->data->notifications + 1,
//                    );
//                    $this->facade->updateByAttributes('notify', $updateNotify, array('userID' => $a));
//                    //sent a notifications
//                    $newNotify = $this->facade->findByAttributes('notify', array('userID' => $a));
//                    $notifications = $newNotify->data->notifications;
//                    $keys = 'notifications.comment.' . $a;
//                    $keys = str_replace(':', '_', $keys);
//                    $data = array(
//                        'type' => 'comment',
//                        'target' => str_replace(':', '_', $postID),
//                        'dispatch' => str_replace(':', '_', $currentUser->recordID),
//                        'content' => $content,
//                        'published' => $published,
//                        'count' => $notifications,
//                    );
//                    $this->service->exchange('dandelion', 'topic')->routingKey($keys)->dispatch('comment', $data);
//                }
//            }
//
//            //update actors to owner's status
//            $duplicate->data->actor = $str;
//            $duplicate->data->timers = $published;
//            $this->facade->updateByPk('activity', $duplicate->recordID, $duplicate);
//        }
        if (!empty($commentRC))
        {
            $userComment = $this->facade->findByPk("user", $commentRC->data->owner);
            $likeComment = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $commentRC->recordID));
            return array('comment' => $commentRC, 'user' => $userComment, 'like' => $likeComment, 'is_object' => 1);
        }
    }

    //just implement
    public function commentStatus()
    {
        if ($this->isLogin())
        {
            $data = $this->comment($_POST['typeID'], 'status', $_POST['comment']);
            $this->render('comment/commentStatus', array('comment' => $data));
        }
    }

    public function commentPhoto()
    {
        $data = $this->comment($_POST['typeID'], 'photo', $_POST['comment']);
        $this->render('comment/commentPhoto', array('comment' => $data['comment'], 'user' => $data['user'], 'like' => $data['like']));
    }

    //just implement
    public function moreComment()
    {
        if ($this->isLogin())
        {
            $statusID = $this->getRecordId($_POST['statusID']);
            $currentUser = $this->getCurrentUser();
            if (!empty($statusID))
            {
                $comment = $this->facade->findAllAttributes('comment', array('typeID' => $statusID));
                $commentArray = array();
                if (!empty($comment))
                {
                    foreach ($comment as $value)
                    {
                        $userComment = $this->facade->findByPk("user", $value->data->owner);
                        $likeComment = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $value->recordID));
                        $commentArray[] = array('comment' => $value, 'user' => $userComment, 'like' => $likeComment);
                    }
                }
                $this->render('comment/moreComment', array('comment' => $commentArray));
            }
        }
    }

}

?>

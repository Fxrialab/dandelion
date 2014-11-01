<?php

class LikeController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public static function findLike($typeID)
    {
        $facade = new DataFacade();
        $model = $facade->findByAttributes('like', array('actor' => F3::get('SESSION.userID'), 'objID' => $typeID));
        if (!empty($model))
            return TRUE;
        else
            return FALSE;
    }

    public function like()
    {
        if ($this->isLogin())
        {
            //filter follow status, qa, photo and all

            $data = explode(';', $_POST['data']);
            $type = $data[0];
            $currentUser = $this->getCurrentUser();
            $objectID = $data[2];
            $published = time();

            $existStatusLikeRC = $this->facade->findByAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $objectID));

            if (!empty($objectID) && empty($existStatusLikeRC))
            {

                $entry = array(
                    'actor' => $currentUser->recordID,
                    'filterLike' => $type,
                    'objID' => $objectID,
                    'published' => $published
                );
                $this->facade->save('like', $entry);
                //update number like to status
                $record = $this->facade->findByPk($type, $objectID);
                $numLike = $record->data->numberLike + 1;
                $updateNumLike = array(
                    'numberLike' => $numLike,
                );
                $this->facade->updateByAttributes($type, $updateNumLike, array('@rid' => '#' . $objectID));
                $this->f3->set('liked', true);
                $this->f3->set('type', $type);
                $this->f3->set('objectID', $objectID);
                $obj = $this->facade->findByPk($type, $objectID);
                $updateNumLike = array(
                    'numberLike' => $numLike,
                );
                $this->facade->updateByAttributes($type, $updateNumLike, array('@rid' => '#' . $objectID));
                //prepare data for dispatch like notifications
                $userIsLiked = $obj->data->owner;
                if ($userIsLiked != $currentUser->recordID) //not like yourself
                {
                    //update to notify class
                    $curNotify = $this->facade->findByAttributes('notify', array('userID' => $userIsLiked));
                    $updateNotify = array(
                        'notifications' => $curNotify->data->notifications + 1,
                    );
                    $this->facade->updateByAttributes('notify', $updateNotify, array('userID' => $userIsLiked));
                    //save to activity class
                    $duplicate = $this->facade->findByAttributes('activity', array('owner' => $userIsLiked, 'verb' => 'like', 'object' => $objectID));
                    if (empty($duplicate))//if do not exist then create it
                    {
                        $entry = array(
                            'owner' => $userIsLiked,
                            'actor' => $currentUser->recordID,
                            'verb' => 'like',
                            'object' => $objectID,
                            'type' => 'notifications',
                            'timers' => $published,
                            'details' => 'like your ' . $type . ':"' . $obj->data->content . '"',
                        );
                        $this->facade->save('activity', $entry);
                    }
                    else
                    {//else update it
                        $update = array(
                            'actor' => $currentUser->recordID . '_' . $duplicate->data->actor,
                            'timers' => $published,
                        );
                        $this->facade->updateByAttributes('activity', $update, array('@rid' => '#' . $duplicate->recordID));
                    }
                    //sent a notifications
                    $newNotify = $this->facade->findByAttributes('notify', array('userID' => $userIsLiked));
                    $notifications = $newNotify->data->notifications;
                    $keys = 'notifications.like.' . $userIsLiked;
                    $keys = str_replace(':', '_', $keys);
                    $data = array(
                        'type' => 'like',
                        'target' => str_replace(':', '_', $objectID),
                        'dispatch' => str_replace(':', '_', $currentUser->recordID),
                        'count' => $notifications,
                    );
                    $this->service->exchange('dandelion', 'topic')->routingKey($keys)->dispatch('like', $data);
                }
//
                echo json_encode(array('liked' => 'unlike', 'id' => str_replace(':', '_', $objectID), 'count' => $numLike, 'title' => 'UnLike', 'type' => $data[0]));
            }
        }
    }

    public function unlike()
    {
        if ($this->isLogin())
        {
            $data = explode(';', $_POST['data']);
            $type = $data[0];
            $currentUser = $this->getCurrentUser();
            $objectID = $data[2];
            //find id of record then delete record
            if (!empty($type) && !empty($objectID))
            {
                //delete like record
                $this->facade->deleteByAttributes('like', array('actor' => $currentUser->recordID, 'filterLike' => $type, 'objID' => $objectID));
                //update activity notifications
                $obj = $this->facade->findByPk($type, $objectID);
                $userIsLiked = $obj->data->owner;

                if ($userIsLiked != $currentUser->recordID) //not unlike yourself
                {
                    $activity = $this->facade->findByAttributes('activity', array('owner' => $userIsLiked, 'verb' => 'like', 'object' => $objectID, 'type' => 'notifications'));
                    $actor = explode('_', $activity->data->actor);
                    $pos = array_search($currentUser->recordID, $actor);
                    unset($actor[$pos]);
                    $str = '';
                    if (count($actor) >= 2)
                    {
                        foreach ($actor as $actors)
                        {
                            $str = $str . $actors . '_';
                        }
                        $str = substr($str, 0, -1);
                    }
                    elseif (count($actor) == 1)
                    {
                        $str = $str . $actor[0];
                    }
                    if (empty($str))
                    {
                        $this->facade->deleteByAttributes('activity', array('owner' => $userIsLiked, 'verb' => 'like', 'object' => $objectID, 'type' => 'notifications'));
                    }
                    else
                    {
                        $update = array(
                            'actor' => $str,
                        );
                        $this->facade->updateByAttributes('activity', $update, array('owner' => $userIsLiked, 'verb' => 'like', 'object' => $objectID, 'type' => 'notifications'));
                    }
                }
                //update number like to status
                $statusRC = $this->facade->findByPk($type, $objectID);
                $numLike = $statusRC->data->numberLike - 1;
                $updateNumLike = array(
                    'numberLike' => $numLike,
                );
                $this->facade->updateByAttributes($type, $updateNumLike, array('@rid' => '#' . $objectID));
                echo json_encode(array('liked' => 'like', 'id' => str_replace(':', '_', $objectID), 'count' => $numLike, 'title' => 'Like', 'type' => $data[0]));
            }
        }
    }

}
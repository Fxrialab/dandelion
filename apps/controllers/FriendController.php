<?php

class FriendController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function sentFriendRequest()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $toUser = $this->f3->get("POST.toUser");
            $userB = str_replace('_', ':', $toUser);
            $existRequestRC = $this->facade->findByAttributes('friendship', array('userA' => $currentUser->recordID, 'relationship' => 'request', 'userB' => $userB));
            $published = time();
            if (!$existRequestRC)
            {
                //prepare data
                $relationship = array(
                    'userA' => $currentUser->recordID,
                    'relationship' => 'request',
                    'status' => 'new',
                    'userB' => $userB,
                    'published' => $published
                );
                //save data
                Model::get('friendship')->createEdge('#' . $currentUser->recordID, '#' . $userB, $relationship);
                //also create a activity
                $entry = array(
                    'owner' => $userB,
                    'actor' => $currentUser->recordID,
                    'verb' => 'sent',
                    'type'  => 'friendRequests',
                    'timers' => $published,
                );
                $this->facade->save('activity', $entry);
                //update to notify class
                $curNotify = $this->facade->findByAttributes('notify', array('userID'=>$userB));
                $updateNotify = array(
                    'friendRequests' => $curNotify->data->friendRequests + 1,
                );
                $this->facade->updateByAttributes('notify', $updateNotify, array('userID'=>$userB));
                //sent a notifications
                $newNotify = $this->facade->findByAttributes('notify', array('userID'=>$userB));
                $friendRequests = $newNotify->data->friendRequests;
                $keys = 'friendRequests.sent.'.$userB;
                $keys = str_replace(':','_', $keys);
                $data = array(
                    'type'  => 'friendRq',
                    'target'=> str_replace(':', '_',$userB),
                    'dispatch'  => str_replace(':', '_',$currentUser->recordID),
                    'count' => $friendRequests,
                );
                $this->service->exchange('dandelion','topic')->routingKey($keys)->dispatch('friendRequests', $data);
            }
            //After friend request is sent. The friendRequests action will be create
            $existFriendRequestAction = $this->facade->findByAttributes('actions', array('actionElement' => 'friendRequests'));
            if (!$existFriendRequestAction)
            {
                $actionRC = array(
                    'actionName' => 'Friend Requests',
                    'actionElement' => 'friendRequests',
                    'isSearch' => 'no',
                    'isSuggest' => 'yes',
                );
                $this->facade->save('actions', $actionRC);
            }
            $this->f3->set('requestFriend', true);
            $this->f3->set('addFriend', false);
            $this->f3->set('isFriend', false);
            $this->f3->set('toUser', $toUser);
            $this->render('home/friend.php', 'default');
        }
    }

    public function acceptFriendship()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $toUser = $this->f3->get("POST.toUser");
            $userB = str_replace('_', ':', $toUser);
            //update a record
            $updateRecord = array(
                'relationship' => 'friend',
                'status' => 'ok'
            );
            $this->facade->updateByAttributes('friendship', $updateRecord, array('userA' => $userB, 'userB' => $currentUser->recordID));
            //prepare data
            $relationship = array(
                'userA' => $currentUser->recordID,
                'relationship' => 'friend',
                'status' => 'ok',
                'userB' => $userB,
                'published' => time()
            );
            //save data
            Model::get('friendship')->createEdge('#' . $currentUser->recordID, '#' . $userB, $relationship);
            //After friend is accept. The peopleYouMayKnow action will be create
            $existPeopleYouMayKnowAction = $this->facade->findByAttributes('actions', array('actionElement' => 'peopleYouMayKnow'));
            if (!$existPeopleYouMayKnowAction)
            {
                $actionRC = array(
                    'actionName' => 'People You May Know',
                    'actionElement' => 'peopleYouMayKnow',
                    'isSearch' => 'yes',
                    'isSuggest' => 'yes',
                );
                $this->facade->save('actions', $actionRC);
            }
            $this->f3->set('requestFriend', false);
            $this->f3->set('addFriend', false);
            $this->f3->set('isFriend', true);
            $this->f3->set('toUser', $toUser);
            $this->render('home/friend.php', 'default');
        }
    }

    public function unAcceptFriendship()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $toUser = str_replace('_', ':', $this->f3->get("POST.toUser"));
            $existRequestAtoB = $this->facade->findByAttributes('friendship', array('userA' => $currentUser->recordID, 'userB' => $toUser));
            $existRequestBtoA = $this->facade->findByAttributes('friendship', array('userA' => $toUser, 'userB' => $currentUser->recordID));
            if (!empty($existRequestAtoB) && !empty($existRequestBtoA))
            {
                Model::get('friendship')->deleteEdge('#' . $currentUser->recordID, '#' . $toUser, array('userA' => $currentUser->recordID, 'relationship' => 'friend', 'userB' => $toUser));
                Model::get('friendship')->deleteEdge('#' . $toUser, '#' . $currentUser->recordID, array('userA' => $toUser, 'relationship' => 'friend', 'userB' => $currentUser->recordID));
            }
            else
            {
                if (!empty($existRequestAtoB) && !$existRequestBtoA)
                {
                    Model::get('friendship')->deleteEdge('#' . $currentUser->recordID, '#' . $toUser, array('userA' => $currentUser->recordID, 'relationship' => 'request', 'userB' => $toUser));
                }
                elseif (!$existRequestAtoB && !empty($existRequestBtoA))
                {
                    Model::get('friendship')->deleteEdge('#' . $toUser, '#' . $currentUser->recordID, array('userA' => $toUser, 'relationship' => 'request', 'userB' => $currentUser->recordID));
                }
            }
            $this->f3->set('requestFriend', false);
            $this->f3->set('addFriend', true);
            $this->f3->set('isFriend', false);
            $this->f3->set('toUser', $toUser);
            $this->render('home/friend.php', 'default');
        }
    }

    public function friends()
    {
        if ($this->isLogin())
        {
            $this->layout = 'timeline';
            $username = $this->f3->get('GET.user');
            if (!empty($username))
            {
                $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $username));
                $currentProfileID = $currentProfileRC->recordID;
                $currentProfileRC = $this->facade->load('user', $currentProfileID);
                $currentUser = $this->getCurrentUser();
                $friends = $this->facade->findAllAttributes('friendship', array('userA'=>$currentProfileRC->recordID, 'relationship'=>'friend','status'=>'ok'));
                //get status friendship
                $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
                $this->render('user/friends.php', 'default',array(
                    'currentUser'   => $currentUser,
                    'otherUser'     => $currentProfileRC,
                    'statusFriendShip'  => $statusFriendShip,
                    'friends'       => $friends
                ));
            }
        }
    }

    public function loadFriend()
    {
        if ($this->isLogin())
        {
            if (!empty($_POST['userID']))
            {
                $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
                $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();
                $obj = new ObjectHandler();
                $obj->userA = $_POST['userID'];
                $obj->relationship = 'friend';
                $obj->status = 'ok';
                $obj->select = "ORDER BY published DESC offset " . $offset . " LIMIT " . $limit;
                $friends = $this->facade->findAll('friendship', $obj);
                if (!empty($friends))
                {
                    foreach ($friends as $value)
                    {
                        $user = $this->facade->findByPk('user', $value->data->userB);
                    }
                    $this->render('user/viewFriend.php', 'default', array('friends'=>$user));
                }
            }
        }
    }

    public function searchFriend()
    {
        if ($this->isLogin())
        {
            $key = $_POST['key'];
            if (!empty($key))
            {
                $command = $this->getSearchCommand(array('fullName'), $key);
                $result = Model::get('user')->callGremlin($command);
                if (!empty($result))
                {
                    foreach ($result as $people)
                    {
                        $friend = Model::get('friendship')->callGremlin("current.map", array('userB' => $people));
                        if (!empty($friend))
                        {
                            $user = $this->facade->findByPk('user', $people);

                        }
                    }
                }
            }
            else
            {
                $obj = new ObjectHandler();
                $obj->userA = $_POST['userID'];
                $obj->select = "ORDER BY published DESC LIMIT 20";
                $friends = $this->facade->findAll('friendship', $obj);
                if (!empty($friends))
                {
                    foreach ($friends as $value)
                    {
                        $user = $this->facade->findByPk('user', $value->data->userB);

                    }
                }
            }
            $this->render('user/viewFriend.php', 'default', array('friends'=>$user));
        }
    }

}

?>
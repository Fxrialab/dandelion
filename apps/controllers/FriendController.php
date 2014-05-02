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
            $currentUser= $this->getCurrentUser();
            $toUser     = $this->f3->get("POST.toUser");
            $userB      = str_replace('_', ':', $toUser);
            $existRequestRC = $this->facade->findByAttributes('friendship', array('userA'=>$currentUser->recordID, 'relationship'=>'request', 'userB'=>$userB));
            if (!$existRequestRC)
            {
                //prepare data
                $relationship   = array(
                    'userA'         => $currentUser->recordID,
                    'relationship'  => 'request',
                    'status'        => 'new',
                    'userB'         => $userB,
                    'published'     => time()
                );
                //save data
                Model::get('friendship')->createEdge('#'.$currentUser->recordID, '#'.$userB, $relationship);
            }
            //After friend request is sent. The friendRequests action will be create
            $existFriendRequestAction   = $this->facade->findByAttributes('actions', array('actionElement'=>'friendRequests'));
            if (!$existFriendRequestAction)
            {
                $actionRC   = array(
                    'actionName'    => 'Friend Requests',
                    'actionElement' => 'friendRequests',
                    'isSearch'      => 'no',
                    'isSuggest'     => 'yes',
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
            $currentUser= $this->getCurrentUser();
            $toUser     = $this->f3->get("POST.toUser");
            $userB      = str_replace('_', ':', $toUser);
            //update a record
            $updateRecord   = array(
                'relationship'  => 'friend',
                'status'        => 'ok'
            );
            $this->facade->updateByAttributes('friendship', $updateRecord, array('userA'=>$userB, 'userB'=>$currentUser->recordID));
            //prepare data
            $relationship   = array(
                'userA'         => $currentUser->recordID,
                'relationship'  => 'friend',
                'status'        => 'ok',
                'userB'         => $userB,
                'published'     => time()
            );
            //save data
            Model::get('friendship')->createEdge('#'.$currentUser->recordID, '#'.$userB, $relationship);
            //After friend is accept. The peopleYouMayKnow action will be create
            $existPeopleYouMayKnowAction   = $this->facade->findByAttributes('actions', array('actionElement'=>'peopleYouMayKnow'));
            if (!$existPeopleYouMayKnowAction)
            {
                $actionRC       = array(
                    'actionName'    => 'People You May Know',
                    'actionElement' => 'peopleYouMayKnow',
                    'isSearch'      => 'yes',
                    'isSuggest'     => 'yes',
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
            $currentUser= $this->getCurrentUser();
            $toUser     = str_replace('_', ':', $this->f3->get("POST.toUser"));
            $existRequestAtoB = $this->facade->findByAttributes('friendship', array('userA'=>$currentUser->recordID, 'userB'=>$toUser));
            $existRequestBtoA = $this->facade->findByAttributes('friendship', array('userA'=>$toUser, 'userB'=>$currentUser->recordID));
            if (!empty($existRequestAtoB) && !empty($existRequestBtoA))
            {
                Model::get('friendship')->deleteEdge('#'.$currentUser->recordID, '#'.$toUser, array('userA'=>$currentUser->recordID, 'relationship'=>'friend', 'userB'=>$toUser));
                Model::get('friendship')->deleteEdge('#'.$toUser, '#'.$currentUser->recordID, array('userA'=>$toUser, 'relationship'=>'friend', 'userB'=>$currentUser->recordID));
            }else {
                if (!empty($existRequestAtoB) && !$existRequestBtoA)
                {
                    Model::get('friendship')->deleteEdge('#'.$currentUser->recordID, '#'.$toUser, array('userA'=>$currentUser->recordID, 'relationship'=>'request', 'userB'=>$toUser));
                }elseif (!$existRequestAtoB && !empty($existRequestBtoA)) {
                    Model::get('friendship')->deleteEdge('#'.$toUser, '#'.$currentUser->recordID, array('userA'=>$toUser, 'relationship'=>'request', 'userB'=>$currentUser->recordID));
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
            $this->layout = 'other';

            $currentUser = $this->getCurrentUser();
            $requestCurrentProfile = $this->f3->get('GET.username');

            if (!empty($requestCurrentProfile))
            {
                $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $requestCurrentProfile));
                if (!empty($currentProfileRC))
                {
                    $currentProfileID = $currentProfileRC->recordID;
                }else {
                    //@TODO: add layout return page not found in later
                    echo "page not found";
                }
            }else
                $currentProfileID = $this->getCurrentUser()->recordID;
            $currentProfileRC = $this->facade->load('user', $currentProfileID);
            $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
            $this->f3->set('statusFriendShip', $statusFriendShip);

            $friendsCurrentUser = Model::get('user')->callGremlin("current.out", array('@rid'=>'#' . $currentProfileID));
            if (!empty($friendsCurrentUser))
            {
                foreach ($friendsCurrentUser as $friend)
                {
                    $infoFriends[$friend] = Model::get('user')->callGremlin("current.map", array('@rid'=>'#' . $friend));
                    $friendsShip[$friend] = $this->getStatusFriendShip($currentUser->recordID, $friend);
                }
                $this->f3->set('friendsCurrentUser', $friendsCurrentUser);
                $this->f3->set('infoFriends', $infoFriends);
                $this->f3->set('friendsShip', $friendsShip);
            }

            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('otherUser', $currentProfileRC);
            $this->render('user/friends.php', 'default');
        }
    }
}

?>
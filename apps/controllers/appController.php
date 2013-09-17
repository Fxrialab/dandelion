<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 2:47 PM
 * Project: UserWired Network - Version: beta
 */
require_once("base.php");
include_once(CONFIG.'amqConfig.php');

class AppController extends Controller
{
    protected $uses     = array("User", "Friendship", "Sessions", "Follow", "Activity", "Edge");
    protected $helpers  = array("Amqp");

    protected $layout   = '';
    //protected $elements = null;

    public function __construct()
    {
        parent::__construct();
        $this->Elements = new ElementController();
    }

    public function beforeRoute()
    {
        //Add some condition later. Set if timeout > 3600 -> disable record session
    }
    /**
     *
     * Some helpful function for controller
     *
     */
    public function isLogin()
    {
        $session = F3::get("SESSION");
        if (isset($session["loggedUser"]))
        {
            return true;
        }
        //session ok
        if (isset($_COOKIE['email']) && isset($_COOKIE['password']))
        {
            $user   =   $this->User->findOne('email = ?',array($_COOKIE['email']));
            F3::clear('SESSION');
            F3::set('SESSION.loggedUser', $user);
            return true;
        }
        //cookie ok
        return false;
    }

    /*public function getCurrentUser()
    {
        return F3::get("SESSION.loggedUser");
    }*/

    public function getCurrentUserName()
    {
        return ucfirst($this->getCurrentUser()->data->firstName) . " ". ucfirst($this->getCurrentUser()->data->lastName);
    }

    public function element($element)
    {
        if (file_exists(UI . ELEMENTS . $element . '.php'))
        {
            if (method_exists($this->Elements, $element))
            {
                $this->Elements->$element();
            }
            require (UI . ELEMENTS . $element . '.php');
        }
    }



    public function getMacAddress()
    {
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $getContents= ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findString = "Physical";
        $macPos     = strpos($getContents, $findString); // Find the position of Physical text
        $mac        = substr($getContents,($macPos + 36), 17); // Get Physical Address
        return $mac;
    }

    public function getIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return $ip;
    }

    public function loadModules($modules)
    {
        if ($modules != '')
            require_once(MODULES . $modules);
    }

    static function elementModules($element,$modules)
    {
        include MODULES.$modules.'/info.php';
        if (file_exists(MODULES.$path.$element.'.php')) {
            foreach(glob(MODULES.$modules.'/controllers/'.$modules.'controller.php') as  $elementController){
                if(file_exists($elementController)) {
                    $elementControllers = $modules.'Controller';
                    $newElement = new $elementControllers;
                    if (method_exists($newElement, $element)) {
                        $newElement->$element();
                    }
                }
            }
            require_once (MODULES.$path.$element.'.php');
        }
    }

    public function sendMessageRab($userID,$object)
    {
        $exchange   = 'socialhub'.$userID;
        $queue      = 'socialhub'.$userID;
        $routingKey = 'socialhub'.$userID;

        $conn = new \PhpAmqpLib\Connection\AMQPConnection(HOST_AMQ, PORT_AMQ, USER_AMQ, PASS_AMQ, VHOST_AMQ);
        $ch = $conn->channel();
        $ch->queue_bind($queue, $exchange,$routingKey);
        $msg_body = "{\"value\":\"".$object."\"}";
        $msg = new \PhpAmqpLib\Message\AMQPMessage($msg_body, array('priority' => '0', 'delivery_mode' => 1));
        $ch->basic_publish($msg, $exchange,$routingKey);
    }

    public function getFriendsStt($actor)
    {
        return $this->Friendship->findByCondition("userA = ? AND relationship = 'friend' AND status = 'ok'", array($actor));
    }

    // **********************************
    // Track activity
    // **********************************
    public function trackActivity($actor, $verb, $object, $published)
    {
        $checkActivity      = $this->Activity->findByCondition("owner = ? AND object = ?", array($actor->recordID, $object));
        $findUserBOfFollow  = $this->Follow->findOne("userA = ? AND ID = ?", array($actor->recordID, $object));
        $actorID            = ($findUserBOfFollow) ? $findUserBOfFollow->data->userB : $actor->recordID;
        if(!$checkActivity)
        {
            // prepare activity data
            $activity = array(
                'owner'     => $actor->recordID,
                'actor'     => $actorID,
                'verb'      => $verb,
                'object'    => $object,
                'type'      => 'post',
                'idObject'  => $object,
                'published' => $published
            );
            // create activity for currentUser
            $activityRC = $this->Activity->create($activity);
            //$this->Edge->createEdge('#'.$actorID, '#'.$activityRC);
            $friends = $this->getFriendsStt($actor->recordID);
            //var_dump($findUserBOfFollow);
            //var_dump($friends);
            // dupicate activities for followers
            if (!empty($friends) && !$checkActivity)
            {
                for ($i = 0; $i < count($friends); $i++)
                {
                    $checkActivityFriend = $this->Activity->findByCondition("owner = ? AND object = ?", array($friends[$i]->data->userB, $object));
                    //var_dump($checkActivityFriend);
                    //@todo handling follow after: HN
                    if($findUserBOfFollow)
                    {
                        $checkFriends   = $this->Friendship->findByCondition("userA = ? AND status = 'ok' userB = ?", array($friends[$i]->data->userB, $findUserBOfFollow->data->userB));
                        if($checkFriends == null)
                        {
                            $activity   = array(
                                'owner'     => $actor->recordID,
                                'actor'     => $findUserBOfFollow->data->userB,
                                'verb'      => $verb,
                                'object'    => $object,
                                'type'      => 'post',
                                'idObject'  => $object,
                                'published' => $published
                            );
                            $activity_id = $this->Activity->create($activity);
                            try {
                                echo "track activity if check friend null <br />";
                                $content = '1'.$activity_id; // 1 is home .
                                $this->sendMessageRab($actor->recordID,$content);
                            } catch(Exception $e) {}
                        }
                    }
                    // prepare activity for each followers
                    if(!$checkActivityFriend)
                    {
                        $activity = array(
                            'owner'     => $friends[$i]->data->userB,
                            'actor'     => $actor->recordID,
                            'verb'      => $verb,
                            'object'    => $object,
                            'type'      => 'post',
                            'idObject'  => $object,
                            'published' => $published
                        );
                        $activity_id = $this->Activity->create($activity);
                        try{
                            echo "track activity if check activity friend null <br />";
                            $content = '1'.$activity_id; // 1 is home .
                            $this->sendMessageRab($friends[$i]->data->userB,$content);
                        } catch(Exception $e){}
                    }
                }
            }

        }
    }

    public function trackComment($actor, $verb, $object, $statusID, $owner, $published)
    {
        $findUser = $this->Comment->findByCondition("post = ?",array($statusID));
        $checkActivity       = $this->Activity->findByCondition("owner = ? AND object = ?", array($actor->recordID, $object));
        $findUserBOfFollow   = $this->Follow->findOne("userA = ? AND ID = ?", array($actor->recordID, $object));
        $actorID = ($findUserBOfFollow) ? $findUserBOfFollow->data->userB : $actor->recordID;
        if(!$checkActivity) {
            /* Insert in to Activity for user posted this status.*/
            if($owner != $actor->recordID){
                $userStatus = array(
                    'owner' => $owner,
                    'actor' => $actor->recordID,
                    'verb' => $verb,
                    'object' => $object,
                    'type'  =>'comment',
                    'idObject'  =>$statusID,
                    'published' => $published
                );

                $activity_id =$this->Activity ->create($userStatus);
                /* Send message to RabbitMQ server */
                try{
                    echo "track comment if check activity null <br />";
                    $content = '2'.$activity_id.'-'.$statusID;
                    $this->sendMessageRab($owner,$content); // 2 la comment
                } catch(Exception $e){}
            }

            $friends = $this->getFriendsStt($actor->recordID);
            /* dupicate activities for followers */
            if (!empty($friends) && !$checkActivity) {
                for ($i = 0; $i < count($friends); $i++) {
                    //@todo handling follow after: HN
                    if($findUserBOfFollow) {
                        $checkFriends        = $this->Friendship->findByCondition("userA = ? AND status = 'ok' userB = ?", array($friends[$i]->data->userB, $findUserBOfFollow->data->userB));
                        if($checkFriends == null) {
                            $activity = array(
                                'owner' => $actor->recordID,
                                'actor' => $findUserBOfFollow->data->userB,
                                'verb' => $verb,
                                'object' => $object,
                                'type'  =>'comment',
                                'idObject'  =>$statusID,
                                'published' => $published
                            );
                            $activity_id =$this->Activity->create($activity);

                            /* Send message to RabbitMQ server */
                            try {
                                $content =  '2'.$activity_id.'-'.$statusID;
                                $this->sendMessageRab($actor->recordID,$content);
                            } catch(Exception $e) {}
                        }
                    }
                }
            }
            /* Insert Activity for user join comment in this status .*/
            if($findUser){
                foreach($findUser as $userCmt){
                    if($userCmt){
                        $checkActivityComment = $this->Activity->findByCondition("owner = ? AND object = ?", array($userCmt->data->actor, $object));
                        if(!$checkActivityComment){
                            if($userCmt->data->actor !=$this->getCurrentUser()->recordID){
                                $userComment = array(
                                    'owner' => $userCmt->data->actor,
                                    'actor' => $this->getCurrentUser()->recordID,
                                    'verb' => $verb,
                                    'object' => $object,
                                    'type'  =>'comment',
                                    'idObject'  =>$statusID,
                                    'published' => $published
                                );
                                $activity_id =$this->Activity ->create($userComment);
                                /* Send message to RabbitMQ server */
                                try{
                                    $content = '2'.$activity_id.'-'.$statusID;
                                    $this->sendMessageRab($userCmt->data->actor,$content);
                                } catch(Exception $e){}
                            }
                        }
                    }
                }
            }
        }
    }

    public function randomKeys($array, $for)
    {
        $result = array();
        $length = count($array);
        switch ($for)
        {
            case 'randomSuggestElement':
                $result = ($array && $length > 2)?array_rand($array,2):array_keys($array);
                break;
            case 'randomFriendID':
                $result = ($length >= 3)?array_rand($array, mt_rand(2, $length)):array_keys($array);
                break;
        }
        return $result;
    }

    public function peopleYouMayKnow()
    {
        $current = array();
        $loggedUser = $this->getCurrentUser()->recordID;
        $findSuggestFriends = $this->User->sqlGremlin("current.out.both", "@rid = ?", array('#'.$loggedUser));

        $groupFriend = array_keys(array_count_values($findSuggestFriends));
        array_push($current, $loggedUser);
        $yourFriends = array_diff($groupFriend, $current);
        $neighborCurrentUser = $this->User->sqlGremlin("current.in", "@rid = ?", array('#'.$loggedUser));
        $yourFriendArrays    = array();
        if (current($yourFriends) != '')
        {
            foreach ($yourFriends as $yourFriend)
            {
                $relationShipAtoB[$yourFriend] = $this->Friendship->findByCondition("userA = ? AND userB = ?", array($loggedUser, $yourFriend));
                $relationShipBtoA[$yourFriend] = $this->Friendship->findByCondition("userA = ? AND userB = ?", array($yourFriend, $loggedUser));
                if (!$relationShipAtoB[$yourFriend] && !$relationShipBtoA[$yourFriend])
                {
                    array_push($yourFriendArrays, $yourFriend);
                }
            }
            $randomKeys = $this->randomKeys($yourFriendArrays, 'randomFriendID');
            foreach ($randomKeys as $key)
            {
                $randYourFriend = $yourFriendArrays[$key];
                $infoYourFriend[$randYourFriend]  = $this->User->sqlGremlin("current.map", "@rid = ?", array('#'.$randYourFriend));
                $neighborFriends[$randYourFriend] = $this->User->sqlGremlin("current.in", "@rid = ?", array('#'.$randYourFriend));

                if (current($neighborCurrentUser) != '')
                {
                    $mutualFriends[$randYourFriend] = array_intersect($neighborCurrentUser, $neighborFriends[$randYourFriend]);

                    foreach ($mutualFriends[$randYourFriend] as $mutualFriend)
                    {
                        $infoMutualFriend[$mutualFriend] = $this->User->sqlGremlin("current.map", "@rid = ?", array('#'.$mutualFriend));
                    }
                }
            }
            F3::set('yourFriendArrays', $yourFriendArrays);
            F3::set('randomKeys', $randomKeys);
            F3::set('yourFriend', $yourFriends);
            F3::set('infoYourFriend', $infoYourFriend);
            F3::set('numMutualFriends', $mutualFriends);
            F3::set('infoMutualFriend', $infoMutualFriend);
        }
        $this->render("elements/peopleYouMayKnowElement.php",'default');
    }

    public function friendRequest()
    {
        $loggedUser = $this->getCurrentUser()->recordID;
        $neighborCurrentUser = $this->User->sqlGremlin("current.in", "@rid = ?", array('#'.$loggedUser));
        $requestUserArrays   = array();
        if (current($neighborCurrentUser) != '')
        {
            foreach ($neighborCurrentUser as $neighbor)
            {
                $requestRelationShip[$neighbor] = $this->Friendship->findByCondition("userA = ? AND userB = ? AND relationship = 'request'", array($neighbor, $loggedUser));

                if ($requestRelationShip[$neighbor])
                {
                    array_push($requestUserArrays, $neighbor);
                }
            }
            $randomKeys = $this->randomKeys($requestUserArrays, 'randomFriendID');
            foreach ($randomKeys as $key)
            {
                $randYourFriend = $requestUserArrays[$key];
                $infoRequestUser[$randYourFriend] = $this->User->sqlGremlin("current.map", "@rid = ?", array('#'.$randYourFriend));
                $neighborRequestUser[$randYourFriend] = $this->User->sqlGremlin("current.in", "@rid = ?", array('#'.$randYourFriend));
                $mutualFriends[$randYourFriend] = array_intersect($neighborCurrentUser, $neighborRequestUser[$randYourFriend]);

                foreach ($mutualFriends[$randYourFriend] as $mutualFriend)
                {
                    $infoMutualFriend[$mutualFriend] = $this->User->sqlGremlin("current.map", "@rid = ?", array('#'.$mutualFriend));
                }
                F3::set('infoRequestUser', $infoRequestUser);
                F3::set('numMutualFriends', $mutualFriends);
                F3::set('infoMutualFriend', $infoMutualFriend);
            }
            F3::set('requestUserArrays', $requestUserArrays);
            F3::set('randomKeys', $randomKeys);
            F3::set('neighborCurrentUser', $neighborCurrentUser);
        }
        $this->render("elements/friendRequestElement.php",'default');
    }

    public function suggest($for)
    {
        switch ($for)
        {
            case 'peopleYouMayKnow':
                $this->peopleYouMayKnow();
                break;
            case 'friendRequests':
                $this->friendRequest();
                break;
            case 'suggestedGroups':
                break;
            case 'findPreferences':
                break;
        }
    }
}
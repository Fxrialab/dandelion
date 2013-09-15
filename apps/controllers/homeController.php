<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/31/13 - 2:18 PM
 * Project: UserWired Network - Version: beta
 */
class HomeController extends AppController
{
    protected $uses     = array("Activity", "User", "Friendship", "Actions");
    protected $helpers  = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout = 'index';
        if ($this->isLogin())
            header("Location:/home");
        else
            $this->render('user/signUp.php', 'default');
    }

    public function home()
    {
        if ($this->isLogin())
        {
            $this->layout = 'default';
            // get activities
            $activitiesRC = $this->Activity->findByCondition("owner = ? AND type = ? ORDER BY published DESC LIMIT 10", array($this->getCurrentUser()->recordID,"post"));
            //check loaded feature
            /*Test */
            /*$current = array();
            $loggedUser = $this->getCurrentUser()->recordID;
            $findSuggestFriends = $this->User->sqlGremlin("current.out.both", "@rid = ?", array('#'.$loggedUser));

            $groupFriend = array_keys(array_count_values($findSuggestFriends));
            array_push($current, $loggedUser);
            $yourFriends = array_diff($groupFriend, $current);
            echo "---------your friends--------";
            var_dump($yourFriends);
            $neighborCurrentUser= $this->User->sqlGremlin("current.in", "@rid = ?", array('#'.$loggedUser));
            echo "-----------neighbor of current user----------";

            var_dump($neighborCurrentUser);
            if (current($yourFriends) != '')
            {
                foreach ($yourFriends as $yourFriend)
                {
                    $infoYourFriend = $this->User->sqlGremlin("current.map", "@rid = ?", array('#'.$yourFriend));
                    echo "----------information of suggest friends-----------";
                    var_dump($infoYourFriend);
                    $neighborFriends = $this->User->sqlGremlin("current.in", "@rid = ?", array('#'.$yourFriend));
                    echo "----------neighbor of friends----------";
                    var_dump($neighborFriends);
                    if (current($neighborCurrentUser) != '')
                    {
                        $mutualFriends= array_intersect($neighborCurrentUser, $neighborFriends);
                        echo "----------mutual friends-----------";
                        var_dump($mutualFriends);
                        //count number mutual friend
                        $numMutualFriends = count($mutualFriends);
                        echo "NUMBER MUTUAL FRIEND: ".$numMutualFriends."<br />";
                        //get info of mutual friend
                        foreach ($mutualFriends as $mutualFriend)
                        {
                            //var_dump($mutualFriend);
                            $infoMutualFriend= $this->User->sqlGremlin("current.map", "@rid = ?", array('#'.$mutualFriend));
                            echo "----------information of mutual friends-----------";
                            var_dump($infoMutualFriend);
                        }
                        //var_dump($infoMutualFriend);
                    }

                }
            }*/
            /*$time = microtime();
            $time = explode(" ", $time);
            $time = $time[1] + $time[0];
            $start = $time;

            $this->peopleYouMayKnow();

            $time = microtime();
            $time = explode(" ", $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $totaltime = ($finish - $start);
            printf ("Gremlin feature Loaded in %f Seconds.", $totaltime);
            echo "<br />";*/
            if ($activitiesRC)
            {
                $homes = array();
                foreach ($activitiesRC as $key=> $activity)
                {
                    $verbMod = $activity->data->verb;
                    if(class_exists($verbMod))
                    {
                        $obj =  new $verbMod;
                        if(method_exists($obj,'postInHome'))
                        {
                            $home = $obj->postInHome($activity,$key);
                            array_push($homes,$home);
                            F3::set('homes',$homes);
                        }
                    }
                }
            }
            //set currentUser and otherUser for check in profile element and header
            F3::set('currentUser', $this->getCurrentUser());
            F3::set('otherUser', $this->getCurrentUser());
            F3::set('currentProfileID', $this->getCurrentUser()->recordID);

            F3::set('SESSION.userProfileID', $this->getCurrentUser()->recordID);
            $this->render('user/home.php','default');
        }else {
            header("Location: /");
        }
    }

    public function homeAMQ()
    {
        if($this->isLogin())
        {
            $activityID     = F3::get('POST.activity_id');
            $activitiesRC   = $this->Activity->findByCondition("@rid = ? ",array($activityID));
            F3::set('currentUser', $this->getCurrentUser());
            if ($activitiesRC )
            {
                $homes = array();
                foreach ($activitiesRC as $key => $activity)
                {
                    $verbMod = $activity->data->verb;
                    if(class_exists($verbMod))
                    {
                        $obj =  new $verbMod;
                        if(method_exists($obj,'postInHome'))
                        {
                            $home = $obj->postInHome($activity,$key);
                            array_push($homes,$home);
                            F3::set('homes',$homes);
                        }
                    }
                }
                $this->render('user/homeAMQ.php','default');
            }
        }else {
            header("Location: /");
        }
    }

    public function morePostHome()
    {
        if($this->isLogin())
        {
            $published = F3::get('POST.published');
            $activitiesRC = $this->Activity->findByCondition("owner = ? and published < ? LIMIT 5 ORDER BY published DESC", array($this->getCurrentUser()->recordID,$published));
            F3::set('currentUser',$this->getCurrentUser());
            if ($activitiesRC)
            {
                $homes = array();
                foreach ($activitiesRC as $key=> $activity)
                {
                    $verbMod = $activity->data->verb;
                    $obj =  new $verbMod;
                    $home = $obj->moreInHome($activity,$key);
                    array_push($homes,$home);
                    F3::set('homes',$homes);
                }
                $this->render('user/moreHome.php','default');
            }else {
                $this->render('user/noMoreHome.php','default');
            }
        }else {
            header("Location: /");
        }
    }

    public function moreCommentHome()
    {
        if ($this->isLogin())
        {
            $activityID = F3::get('POST.activity_id');
            $activitiesRC = $this->Activity->findByCondition("@rid = ? ",array($activityID));
            if ($activitiesRC )
            {
                $resultComments = array();
                foreach($activitiesRC as $oneComment)
                {
                    $modulesType =substr($oneComment->data->verb,0,strpos($oneComment->data->verb,$oneComment->data->object)).'controller';
                    foreach(glob(MODULES.'*/controllers/'.$modulesType.'.php') as $modulesFileControl ){
                        if(file_exists($modulesFileControl))
                        {
                            $modController =  new $modulesType ;
                            if(method_exists($modController,'loadComment'))
                            {
                                $resultComment = $modController->loadComment($oneComment->data->object,$oneComment->data->actor,$oneComment->recordID);
                                array_push($resultComments,$resultComment);
                            }
                        }
                    }
                }
                F3::set('commentAmq',$resultComments);
                $this->render('user/commentAMQ.php','default');
            }
        }else {
            header("Location: /");
        }
    }

    public function pull()
    {
        if ($this->isLogin())
        {
            $listActionsForSuggest  = $this->Actions->findByCondition("isSuggest = ?", array('yes'));
            $actionClusterID        = $this->Actions->getClusterID();
            $actionID               = $actionClusterID.":".rand(0, count($listActionsForSuggest) - 1);
            $suggestAction          = $this->Actions->findByCondition("isSuggest = 'yes' AND @rid = ?", array('#'.$actionID));

            F3::set('listActions', $suggestAction);
            $this->render('elements/loadedSuggestElement.php','default');
        }
    }

    public function loadSuggest()
    {
        if ($this->isLogin())
        {
            $actionArrays = F3::get('POST.actionsName');
            foreach ($actionArrays as $action)
            {
                $this->suggest($action);
            }
        }
    }
}
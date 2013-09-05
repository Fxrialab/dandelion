<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/31/13 - 2:18 PM
 * Project: UserWired Network - Version: beta
 */
class HomeController extends AppController
{
    protected $uses     = array("Activity", "User");
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
            $gremlin = $this->User->sqlGremlin("current.in.username", "@rid = ?", array('#'.$this->getCurrentUser()->recordID));
            var_dump($gremlin);

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
}
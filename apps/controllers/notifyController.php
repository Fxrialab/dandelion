<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/21/13 - 9:23 PM
 * Project: UserWired Network - Version: beta
 */
class NotifyController extends AppController
{
    protected $uses     = array("Notify", "Activity");
    protected $helpers  = array();

    public function __construct()
    {
        parent::__construct();
    }

    //ajax display content notify
    public function notify()
    {
        $activity_id = F3::get('POST.activity_id');
        /* Save notify when user not view */
        $getNotify = $this->Notify->findOne('userID = ?',array($this->getCurrentUser()->recordID));
        if($getNotify){
            $notify = array(
                'notify' => $getNotify->data->notify + 1 //@todo  check for requestFriend and message.
            );
            $this->Notify->updateByCondition($notify,"@rid = ?",array("#".$getNotify->recordID));
        }
        /* End save  */

        $activitiesStatus = $this->Activity->findByCondition("@rid = ? ",array($activity_id));
        if ($activitiesStatus ) {
            $resultComments = array();
            foreach($activitiesStatus as $oneComment){
                $modulesType = substr($oneComment->data->verb,0,strpos($oneComment->data->verb,$oneComment->data->object));
                $modulesControllerFile = MODULES.$modulesType.'/controllers/'.$modulesType.'Controller.php';

                foreach(glob($modulesControllerFile) as $modulesFileControl)
                {
                    if(file_exists($modulesFileControl))
                    {
                        $controller = $modulesType.'Controller';
                        $modController =  new $controller;
                        if(method_exists($modController,'loadComment')){
                            $resultComment = $modController->loadComment($oneComment->data->object,$oneComment->data->actor,$oneComment->recordID);
                            array_push($resultComments,$resultComment);
                        }
                    }
                }
            }
            F3::set('notifyAjax',$resultComments);
            $this->render('elements/notifyElement.php','default');
        }
    }

    public function updateNotification()
    {
        $notifyStatus = $this->Notify->findOne('userID = ?',array($this->getCurrentUser()->recordID));
        if($notifyStatus)
        {
            $notify = array(
                'notify'    => 0
            );
            $this->Notify->updateByCondition($notify,"@rid = ?",array("#".$notifyStatus->recordID));
        }
    }

}

?>
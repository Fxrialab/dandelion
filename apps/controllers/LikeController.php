<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/27/13 - 2:46 PM
 * Project: userwired Network - Version: 1.0
 */
class LikeController extends AppController {

//    protected $uses = array("Like", "Status", "Photo");
    protected $helper = array();

    public function __construct() {
        parent::__construct();
    }

    public function like() {
        if ($this->isLogin()) {
//            $getIDUser  = $this->f3->get("POST.id");
//            $userA      = $this->getCurrentUser()->recordID;
//            $userB      = Model::get('user')->getClusterID().':'.$getIDUser;
            //filter follow status, qa, photo and all
            $owner = $this->getCurrentUser()->recordID;
            $actor = str_replace('_', ':', $_POST['actor']);
            $statusID = $this->f3->get("POST.statusID");
//            $photoID    = $this->f3->get("POST.photoID");
            $published = time();

            $existStatusLikeRC = Model::get('like')->findOne("userA = ? AND ID = ?", array($owner, str_replace('_', ':', $statusID)));

            if ($statusID && $actor && empty($existStatusLikeRC)) {
                $statusID = str_replace('_', ':', $statusID);
                $data = array(
                    'owner' => $owner,
                    'actor' => $actor,
                    'isLike' => 'like',
                    'filterLike' => 'post',
                    'ID' => $statusID,
                    'published' => $published
                );
                Model::get('like')->create($data);
                //update number like to status
                $statusRC = Model::get('status')->findOne('@rid = ?', array('#' . $statusID));
                $numLike = $statusRC->data->numberLike + 1;
                $updateNumLike = array(
                    'numberLike' => $numLike,
                );
                Model::get('status')->updateByCondition($updateNumLike, "@rid = ?", array("#" . $statusID));
                $facade = new OrientDBFacade();
                $like = $facade->findByAttributes('like', array('owner' => $owner, 'ID' => $statusID));
                $this->f3->set('likes', '123');
                $this->render('home/like.php', 'default');
//                echo json_encode($numLike);
            }
        }
    }

    public function unlike() {
        if ($this->isLogin()) {
//            $getIDUser  = $this->f3->get("POST.id");
//            $userA      = $this->getCurrentUser()->recordID;
//            $userB      = $this->User->getClusterID().':'.$getIDUser;
//            $statusID   = $this->f3->get("POST.statusID");
//            $photoID    = $this->f3->get("POST.photoID");

            $owner = $this->getCurrentUser()->recordID;
            $actor = str_replace('_', ':', $_POST['actor']);
            $statusID = $this->f3->get("POST.statusID");
            //find id of record then delete record
            if (!empty($statusID) && !empty($owner) && !empty($actor)) {
                $statusID = str_replace('_', ':', $statusID);
                Model::get('like')->deleteByCondition("owner = ? AND actor = ? AND ID = ?", array($owner, $actor, $statusID));
                //update number like to status
                $statusRC = Model::get('status')->findOne('@rid = ?', array('#' . $statusID));
                $numLike = $statusRC->data->numberLike - 1;
                $updateNumLike = array(
                    'numberLike' => $numLike,
                );
                Model::get('status')->updateByCondition($updateNumLike, "@rid = ?", array("#" . $statusID));
                echo json_encode($numLike);
            }
        }
    }

}
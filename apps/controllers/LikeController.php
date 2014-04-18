<?php

class LikeController extends AppController
{

    public function __construct() {
        parent::__construct();
    }

    public function like()
    {
        if ($this->isLogin())
        {
            //filter follow status, qa, photo and all
            $currentUser= $this->getCurrentUser();
            $type       = $this->f3->get("POST.type");
            $objectID   = str_replace('_', ':', $this->f3->get("POST.objectID"));
            $published  = time();

            $existStatusLikeRC = $this->facade->findByAttributes('like', array('actor'=>$currentUser->recordID, 'objID'=>$objectID));

            if (!empty($objectID) && empty($existStatusLikeRC))
            {
                $data = array(
                    'actor'     => $currentUser->recordID,
                    'filterLike'=> $type,
                    'objID'     => $objectID,
                    'published' => $published
                );
                $this->facade->save('like', $data);
                //update number like to status
                $statusRC = $this->facade->findByPk($type, $objectID);
                $numLike = $statusRC->data->numberLike + 1;
                $updateNumLike = array(
                    'numberLike' => $numLike,
                );
                $this->facade->updateByAttributes($type, $updateNumLike, array('@rid'=>'#'.$objectID));
                $this->f3->set('liked', true);
                $this->f3->set('type', $type);
                $this->f3->set('objectID', $objectID);
                $this->f3->set('owner', $statusRC->data->owner);
                $this->f3->set('currentUser', $currentUser);
                $this->render('home/like.php', 'default');
            }
        }
    }

    public function unlike()
    {
        if ($this->isLogin())
        {
            $currentUser= $this->getCurrentUser();
            $type       = $this->f3->get("POST.type");
            $objectID   = str_replace('_', ':', $this->f3->get("POST.objectID"));
            $published  = time();
            //find id of record then delete record
            if (!empty($type) && !empty($objectID))
            {
                $this->facade->deleteByAttributes('like', array('actor'=>$currentUser->recordID, 'filterLike'=>$type, 'objID'=>$objectID));
                //update number like to status
                $statusRC = $this->facade->findByPk($type, $objectID);
                $numLike = $statusRC->data->numberLike - 1;
                $updateNumLike = array(
                    'numberLike' => $numLike,
                );
                $this->facade->updateByAttributes($type, $updateNumLike, array('@rid'=>'#'.$objectID));
                $this->f3->set('liked', false);
                $this->f3->set('type', $type);
                $this->f3->set('objectID', $objectID);
                $this->render('home/like.php', 'default');
            }
        }
    }

}
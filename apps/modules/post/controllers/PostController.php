<?php

/**
 * Author: Hoc Nguyen
 * Date: 12/21/12
 */
class PostController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    static function getFindComment($postID)
    {
        $facade = new DataFacade();
        $comment = $facade->findAllAttributes('comment', array('post' => str_replace("_", ":", $postID)));
        return $comment;
    }

    static function getPhoto($id)
    {
        return Model::get('photo')->find(str_replace("_", ":", $id));
    }

    static function getStatus($id)
    {
        return Model::get('group')->find($id);
    }

    static function getUser($id)
    {
        $facade = new DataFacade();
        return $facade->findByPk('user', str_replace("_", ":", $id));
    }

    //has implement and fix logic
    public function post($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'timeline';

            $requestCurrentProfile = $this->f3->get('GET.username');
            if (!empty($requestCurrentProfile))
            {
                $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $requestCurrentProfile));
                if (!empty($currentProfileRC))
                {
                    $currentProfileID = $currentProfileRC->recordID;
                }
                else
                {
                    //@TODO: add layout return page not found in later
                    echo "page not found";
                }
            }
            else
                $currentProfileID = $this->getCurrentUser()->recordID;
            $this->f3->set('SESSION.userProfileID', $currentProfileID);
            $currentProfileRC = $this->facade->load('user', $currentProfileID);
            $currentUser = $this->getCurrentUser();
            //get status friendship
            $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
            //set
            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('otherUser', $currentProfileRC);

            $this->f3->set('statusFriendShip', $statusFriendShip);
            //set ID for postWrap.php
            $this->f3->set("currentProfileID", $currentProfileID);

            $this->render($viewPath . 'myPost.php', 'modules');
        }
        else
        {
            
        }
    }

    public function loading()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $currentProfileID = $this->f3->get('SESSION.userProfileID');
            if (!empty($currentProfileID))
            {
                $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
                $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();
                $obj = new ObjectHandler();
                $obj->owner = $currentProfileID;
                $obj->active = 1;
                $obj->select = "ORDER BY published DESC offset ".$offset." LIMIT ".$limit;
                $statusRC = $this->facade->findAll('status', $obj);
                //var_dump($statusRC);
                if (!empty($statusRC))
                {
                    foreach ($statusRC as $status)
                    {
                        $likeStatus[($status->recordID)] = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $status->recordID));
                    }
                    $this->f3->set("listStatus", $statusRC);
                    $this->f3->set("likeStatus", $likeStatus);
                    $this->renderModule('post','post');
                }
            }
        }
    }

    public function delete()
    {
        if ($this->isLogin())
        {
            $postID = str_replace('_', ':', $this->f3->get('POST.objectID'));
            if (!empty($postID) && !is_array($postID))
            {
                $active = array(
                    'active' => 0,
                );
                $this->facade->updateByAttributes('status', $active, array('@rid' => '#' . $postID));
            }
        }
    }

    //has implement and fix logic
    public function postStatus()
    {
        if ($this->isLogin())
        {
            $published      = time();
            $currentUser    = $this->getCurrentUser();
            $friendProfileID= $this->f3->get('SESSION.userProfileID');
            $content        = $this->f3->get("POST.status");
            $type           = $this->f3->get("POST.type");
            //determine embed type if existing
            $embedType      = $this->f3->get('POST.embedType');
            if (!$embedType || $embedType == 'none')
                $embedSource    = false;
            else {
                if ($embedType == 'photo')
                {
                    $images         = $this->f3->get("POST.imgID");
                    $embedSource    = implode(',',$images);
                }else {
                    $video  = $this->f3->get("POST.videoURL");

                    $countChar      = strlen($video);
                    $countCharFirst = strpos($content, $video);
                    $content1       = substr($content, 0, $countCharFirst);
                    $content2       = substr($content, $countChar + $countCharFirst);
                    $content        = $content1 . "_linkWith_" . $content2;
                    $embedSource    = $video;
                }
            }
            if (!empty($_POST['typeID']))
                $typeID = $_POST['typeID'];
            else
                $typeID = FALSE;
            // prepare data
            $postEntry = array(
                'owner'         => $this->f3->get('SESSION.userID'),
                'actor'         => $currentUser->recordID,
                'content'       => $content,
                'embedType'     => $embedType,
                'embedSource'   => $embedSource,
                'actorName'     => $this->getCurrentUserName(),
                'numberLike'    => '0',
                'numberComment' => '0',
                'published'     => $published,
                'numberShared'  => '0',
                'contentShare'  => 'none',
                'numberFollow'  => '0',
                'mainStatus'    => 'none',
                'active'        => '1',
                'type'          => $type,
                'typeID'        => $typeID
            );

            // save
            $statusID = $this->facade->save('status', $postEntry);
            // track activity
            $this->trackActivity($currentUser, 'ListController', $statusID, $type, $typeID, $published);
            $status = $this->facade->findByPk('status', $statusID);
            $this->f3->set('status', $status);
            $this->f3->set('statusID', $statusID);
            $this->f3->set('content', $content);
            //$this->f3->set('tagged', 'none');
            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('published', $published);
            $this->renderModule('postStatus', 'post');
        }
    }

    //just implement
    public function postComment()
    {
        if ($this->isLogin())
        {
            $facade = new OrientDBFacade();
            $currentUser = $this->getCurrentUser();
            $postID = str_replace("_", ":", $this->f3->get('POST.postID'));
            $actorName = $this->getCurrentUserName();
            $published = time();
            $existCommentRC = $facade->findAllAttributes('comment', array("actor" => $currentUser->recordID, "post" => $postID));
            //prepare data
            $content = $this->f3->get('POST.comment');
            $URL = $this->f3->get('POST.fullURL');
            $tagged = ($URL == 'undefined') ? 'none' : $URL;
            if ($tagged != 'none')
            {
                $countChar = strlen($tagged);
                $countCharFirst = strpos($content, $tagged);
                $content1 = substr($content, 0, $countCharFirst);
                $content2 = substr($content, $countChar + $countCharFirst);
                $content = $content1 . "_linkWith_" . $content2;
            }
            //target for count who comments to post on notification, will check later

            if ($existCommentRC)
            {
                $commentEntryCase = array(
                    "actor" => $currentUser->recordID,
                    "actor_name" => $actorName,
                    "content" => $content,
                    "post" => $postID,
                    "status_post" => "later",
                    "published" => $published,
                    "tagged" => $tagged
                );
            }
            else
            {
                $commentEntryCase = array(
                    "actor" => $currentUser->recordID,
                    "actor_name" => $actorName,
                    "content" => $content,
                    "post" => $postID,
                    "status_post" => "first",
                    "published" => $published,
                    "tagged" => $tagged
                );
            }
            $commentRC = Model::get('comment')->create($commentEntryCase);
            $commentID = $commentRC;
            /* Update number comment */
            $status_update = Model::get('status')->findOne('@rid = ?', array('#' . $postID));
            $dataCountNumberComment = array(
                'numberComment' => $status_update->data->numberComment + 1
            );
            Model::get('status')->updateByCondition($dataCountNumberComment, "@rid = ?", array("#" . $postID));

            // track activity
            $userPostID = Model::get('status')->findOne("@rid = ?", array($postID));
            $this->trackComment($currentUser, "post" . $commentID, $commentID, $postID, $userPostID->data->actor, $published); //commentHoc SAVE Activity follow object is ID comment
            // data for ajax
            $this->f3->set('published', $published);
            $this->f3->set('content', $content);
            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('postID', $postID);
            $this->f3->set('tagged', $tagged);

            $this->renderModule('postComment', 'post');
        }
        else
        {
            
        }
    }

    //just implement
    public function moreComment()
    {
        if ($this->isLogin())
        {
            $statusID = str_replace("_", ":", $this->f3->get('POST.statusID'));
            if (!empty($statusID))
            {
                $comments = Model::get('comment')->findByCondition("post = '" . $statusID . "'  ORDER BY published DESC");
//                if (!empty($comments)) {
//                    $pos = (count($comments) < 50 ? count($comments) : 50);
//                    for ($j = $pos - 1; $j >= 0; $j--) {
//                        $commentActor[$comments[$j]->data->actor] = Model::get('user')->load($comments[$j]->data->actor);
//                    }
//                } else {
//                    $commentActor = null;
//                }
//                $this->f3->set("commentActor", $commentActor);
                $this->f3->set("comments", $comments);
                $this->renderModule('moreComment', 'post');
            }
        }
    }

    //just implement
    public function shareStatus()
    {
        if ($this->isLogin())
        {
            $statusID = str_replace('_', ':', $this->f3->get('POST.statusID'));
            $statusRC = $this->facade->findByPk('status', $statusID);
            $user = $this->facade->findByPk('user', $statusRC->data->owner);
            $this->f3->set('status', $statusRC);
            $this->f3->set('user', $user);
            $this->renderModule('shareStatus', 'post');
        }
    }

    //just implement
    public function insertStatus()
    {
        if ($this->isLogin())
        {
            $published  = time();
            $statusID   = str_replace('_', ':', $this->f3->get("POST.statusID"));
            $txtShare   = $this->f3->get("POST.shareTxt");
            $parentStatus = $this->facade->findByPk('status', $statusID);
            $parentStatus->data->numberShared = $parentStatus->data->numberShared + 1;
            $this->facade->updateByPk('status', $statusID, $parentStatus);
            $postEntry = array(
                'owner'         => $this->getCurrentUser()->recordID,
                'actor'         => $parentStatus->data->owner,
                'content'       => $parentStatus->data->content,
                'embedType'     => $parentStatus->data->embedType,
                'embedSource'   => $parentStatus->data->embedSource,
                'actorName'     => $parentStatus->data->actorName,
                'numberLike'    => '0',
                'numberComment' => $parentStatus->data->numberComment,
                'published'     => $published,
                'contentShare'  => $txtShare,
                'numberShared'  => '0',
                'numberFollow'  => '0',
                'mainStatus'    => $statusID,
                'active'        => '1',
                'type'          => $parentStatus->data->type,
                'typeID'        => $parentStatus->data->typeID
            );
            // save
            $status = $this->facade->save('status', $postEntry);
            // track activity
            $this->trackActivity($this->getCurrentUser(), 'ListController', $status, $parentStatus->data->type, $parentStatus->data->typeID, $published);
        }
    }

    //just implement
    public function detailStatus()
    {
        if ($this->isLogin())
        {
            $this->layout = 'default';
            $statusID = F3::get('GET.id');
            $status = $this->Status->load($statusID);
            $comment = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published ASC", array($statusID));
            $userFriend = $this->User->findOne("@rid = ?", array($status->data->owner));
            $getStatusFollow = $this->Follow->findOne("userA = ? AND userB = ? AND filterFollow = 'post' AND ID = ?", array($status->data->owner, $status->data->actor, $statusID));
            $statusFollow = ($getStatusFollow == null) ? 'null' : $getStatusFollow->data->follow;
            $currentUser = $this->getCurrentUser();
            F3::set('statusFollow', $statusFollow);
            //F3::set('username', ucfirst($this->getCurrentUser()->data->firstName) . " " . ucfirst($this->getCurrentUser()->data->lastName));
            F3::set('currentUser', $currentUser);
            F3::set('otherUser', $currentUser);
            F3::set('userFriend', $userFriend);
            F3::set('comment', $comment);
            F3::set('status_detail', $status);
            $this->render(Register::getPathModule('post') . 'detailStatus.php', 'modules');
        }
    }

}

?>

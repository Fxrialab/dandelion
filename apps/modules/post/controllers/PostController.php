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

            $username = $this->f3->get('GET.user');
            if (!empty($username))
            {
                $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $username));
                $currentProfileID = $currentProfileRC->recordID;
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
            }

            $this->render($viewPath . 'myPost.php', 'modules');
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
                $obj->type  = 'post';
                $obj->active = 1;
                $obj->select = "ORDER BY published DESC offset " . $offset . " LIMIT " . $limit;
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
                    $this->renderModule('post', 'post');
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
            $published = time();
            $currentUser = $this->getCurrentUser();
            $friendProfileID = $this->f3->get('SESSION.userProfileID');
            $content = $this->f3->get("POST.status");
            $type = $this->f3->get("POST.type");
            //determine embed type if existing
            $embedType = $this->f3->get('POST.embedType');
            if (!$embedType || $embedType == 'none')
                $embedSource = false;
            else
            {
                if ($embedType == 'photo')
                {
                    $images = $this->f3->get("POST.imgID");
                    $embedSource = implode(',', $images);
                }
                else
                {
                    $video = $this->f3->get("POST.videoURL");

                    $countChar = strlen($video);
                    $countCharFirst = strpos($content, $video);
                    $content1 = substr($content, 0, $countCharFirst);
                    $content2 = substr($content, $countChar + $countCharFirst);
                    $content = $content1 . "_linkWith_" . $content2;
                    $embedSource = $video;
                }
            }
            if (!empty($_POST['typeID']))
                $typeID = $_POST['typeID'];
            else
                $typeID = FALSE;
            // prepare data
            $postEntry = array(
                'owner' => $this->f3->get('SESSION.userID'),
                'actor' => $currentUser->recordID,
                'content' => $content,
                'embedType' => $embedType,
                'embedSource' => $embedSource,
                'actorName' => $this->getCurrentUserName(),
                'numberLike' => '0',
                'numberComment' => '0',
                'published' => $published,
                'numberShared' => '0',
                'contentShare' => 'none',
                'numberFollow' => '0',
                'mainStatus' => 'none',
                'active' => '1',
                'type' => $type,
                'typeID' => $typeID
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
            $currentUser = $this->getCurrentUser();
            $postID     = str_replace("_", ":", $this->f3->get('POST.postID'));
            $published  = time();

            //prepare data
            $content = $this->f3->get('POST.comment');
            //target for count who comments to post on notification, will check later
            $commentEntryCase = array(
                "actor"         => $currentUser->recordID,
                "content"       => $content,
                "post"          => $postID,
                "published"     => $published,
            );
            $commentID = $this->facade->save('comment',$commentEntryCase);
            $commentRC = $this->facade->findByPk('comment', $commentID);
            /* Update number comment */
            $status_update = $this->facade->findByAttributes('status', array('@rid'=>'#' . $postID));
            $dataCountNumberComment = array(
                'numberComment' => $status_update->data->numberComment + 1
            );
            $this->facade->updateByAttributes('status', $dataCountNumberComment, array('@rid'=>"#" . $postID));
            $this->f3->set('comments', $commentRC);

            $this->renderModule('viewComment', 'post');
        }else {
            
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
                $comments = $this->facade->findAllAttributes('comment', array('post'=>$statusID));
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
            $published = time();
            $statusID = str_replace('_', ':', $this->f3->get("POST.statusID"));
            $txtShare = $this->f3->get("POST.shareTxt");
            $parentStatus = $this->facade->findByPk('status', $statusID);
            $parentStatus->data->numberShared = $parentStatus->data->numberShared + 1;
            $this->facade->updateByPk('status', $statusID, $parentStatus);
            $postEntry = array(
                'owner' => $this->getCurrentUser()->recordID,
                'actor' => $parentStatus->data->owner,
                'content' => $parentStatus->data->content,
                'embedType' => $parentStatus->data->embedType,
                'embedSource' => $parentStatus->data->embedSource,
                'actorName' => $parentStatus->data->actorName,
                'numberLike' => '0',
                'numberComment' => $parentStatus->data->numberComment,
                'published' => $published,
                'contentShare' => $txtShare,
                'numberShared' => '0',
                'numberFollow' => '0',
                'mainStatus' => $statusID,
                'active' => '1',
                'type' => $parentStatus->data->type,
                'typeID' => $parentStatus->data->typeID
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

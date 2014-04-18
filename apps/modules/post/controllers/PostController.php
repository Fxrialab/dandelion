<?php

/**
 * Author: Hoc Nguyen
 * Date: 12/21/12
 */
class PostController extends AppController
{

    public function __construct() {
        parent::__construct();
    }

    static function getFindComment($postID) {
        $facade = new DataFacade();
        $comment = $facade->findAllAttributes('comment', array('post'=>str_replace("_", ":", $postID)));
        return $comment;
    }

    static function getPhoto($id) {
        return Model::get('photo')->findByPk($id);
    }

    static function getStatus($id) {
        return Model::get('status')->findByPk($id);
    }

    static function getUser($id) {
        $facade = new DataFacade();
        return $facade->findByPk('user', str_replace("_", ":", $id));
    }

    //has implement and fix logic
    public function myPost($viewPath)
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
                } else {
                    //@TODO: add layout return page not found in later
                    echo "page not found";
                }
            }else
                $currentProfileID = $this->getCurrentUser()->recordID;
            $this->f3->set('SESSION.userProfileID', $currentProfileID);
            $currentProfileRC = Model::get('user')->load($currentProfileID);
            $currentUser = $this->getCurrentUser();
            //get status friendship
//            $statusFriendShipRC = Model::get('friendship')->findOne('userA = ? AND userB = ?', array($currentUser->recordID, $currentProfileRC->recordID));
            $statusFriendShipRC = $this->facade->findByAttributes('friendship', array('userA' => $currentUser->recordID, 'userB' => $currentProfileRC->recordID));
            $statusFriendship = ($statusFriendShipRC == NULL) ? 'null' : $statusFriendShipRC->data->relationship;
            //set
            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('otherUser', $currentProfileRC);

            $this->f3->set('statusFriendShip', $statusFriendship);
            //set ID for postWrap.php
            $this->f3->set("currentProfileID", $currentProfileID);
            // get id status of user was following.
            $getFollowRC = $this->facade->findByAttributes('follow', array('userA' => $currentProfileID, 'filterFollow' => 'post'));
            /* if exist status following. Get status following and get status of this user. */
            if ($getFollowRC) {
                $obj =  new ObjectHandler();
                $obj->owner = $currentProfileID;
                $obj->active = 1;
                $obj->select = "OR @rid = '" . $getFollowRC->data->ID . "' ORDER BY published DESC LIMIT 5";
                $statusRC = $this->facade->findAll('status', $obj);
            } else {
                $obj =  new ObjectHandler();
                $obj->owner = $currentProfileID;
                $obj->active = 1;
                $obj->select = "ORDER BY published DESC LIMIT 5";
                $statusRC = $this->facade->findAll('status', $obj);
            }

            if (!empty($statusRC)) {
                foreach ($statusRC as $status) {
                    $comments[($status->recordID)] = $this->facade->findAll('comment', array("post" => $status->recordID));
                    $numberOfComments[($status->recordID)] = $this->facade->count("comment", $status->recordID);
                    //get status follow, like
                    $likeStatus[($status->recordID)] = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID,'objID'=>$status->recordID));
                    $statusFollow[($status->recordID)] = $this->getFollowStatus($status->recordID, $currentUser->recordID);
                    //get info user actor
                    $postActor[($status->data->actor)] = $this->facade->load('user', $status->data->actor);
                    if ($comments[($status->recordID)]) {
                        $pos = (count($comments[($status->recordID)]) < 3 ? count($comments[($status->recordID)]) : 3);
                        for ($j = $pos - 1; $j >= 0; $j--) {
                            $commentActor[$comments[($status->recordID)][$j]->data->actor] = $this->facade->load('user',$comments[($status->recordID)][$j]->data->actor);
                        }
                        $this->f3->set("commentActor", $commentActor);
                    }
                }

                $this->f3->set("listStatus", $statusRC);
                $this->f3->set("comments", $comments);
                $this->f3->set("numberOfComments", $numberOfComments);
                $this->f3->set("likeStatus", $likeStatus);
                $this->f3->set("statusFollow", $statusFollow);
                $this->f3->set("postActor", $postActor);
            }
            $this->render($viewPath . 'myPost.php', 'modules');
        } else {
            
        }
    }

    public function delete()
    {
        if ($this->isLogin())
        {
            $postID = str_replace('_', ':',$this->f3->get('POST.objectID'));
            if (!empty($postID) && !is_array($postID))
            {
                $active = array(
                    'active' => 0,
                );
                $this->facade->updateByAttributes('status', $active, array('@rid'=>'#'.$postID));
            }
        }
    }

    //just implement
    public function loadComment($object, $actor, $activityID) {
        if ($this->isLogin()) {
            $findStatus = $this->Comment->findByCondition("@rid = ?", array('#' . $object));
            //var_dump($findStatus);
            if ($findStatus) {
                $findContentStt = $this->Status->findByCondition("@rid = ?", array('#' . $findStatus[0]->data->post));
                $lengthComment = strlen($findContentStt[0]->data->content);
                $contentStatusDisplay = ($lengthComment > 40) ? str_replace(substr($findContentStt[0]->data->content, 40), '...', $findContentStt[0]->data->content) : $findContentStt[0]->data->content;
                $profileCommentActor[$actor] = $this->User->load($actor);
                $entry = array(
                    'activityID' => $activityID,
                    'currentUser' => $this->getCurrentUser(),
                    'name' => $findStatus[0]->data->actor_name,
                    'pfCommentActor' => $profileCommentActor,
                    'content' => $contentStatusDisplay,
                    'numberComment' => $findContentStt[0]->data->numberComment,
                    'published' => $findStatus[0]->data->published,
                    'text' => 'has comment ',
                    'actor' => $actor,
                    'commentID' => $object,
                    'owner' => $findContentStt[0]->data->owner,
                    'link' => 'detailStatus?id=' . $findStatus[0]->data->post,
                    'type' => 'status',
                    'contentCmt' => $findStatus[0]->data->content,
                    'tagged' => $findContentStt[0]->data->tagged,
                    'path' => Register::getPathModule('post'),
                );
                return $entry;
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
            $taggedElement = $this->f3->get("POST.fullURL");
            //@TODO: check type of tagged later
            //$taggedType         = F3::get("POST.taggedType");
            $content = $this->f3->get("POST.status");
            $img = substr(($this->f3->get("POST.img")), 0, -1);
            if ($taggedElement != 'none')
            {
                $countChar = strlen($taggedElement);
                $countCharFirst = strpos($content, $taggedElement);
                $content1 = substr($content, 0, $countCharFirst);
                $content2 = substr($content, $countChar + $countCharFirst);
                $content = $content1 . "_linkWith_" . $content2;
            }
            // prepare data
            $postEntry = array(
                'owner' => $this->f3->get("POST.profileID"),
                'actor' => $currentUser->recordID,
                'content' => $content,
                'tagged' => $taggedElement,
                /* 'taggedType'    => $taggedType, */
                'actorName' => $this->getCurrentUserName(),
                /* 'lastTwoComment'=> '', */
                'numberLike' => '0',
                'numberComment' => '0',
                'published' => $published,
                'numberShared' => '0',
                'contentShare' => 'none',
                'numberFollow' => '0',
                'mainStatus' => 'none',
                'active' => '1',
                'img' => $img
            );

            // save
            $status = $this->facade->save('status',$postEntry);
            $this->f3->set('statusID', $status);
            // track activity
            $this->trackActivity($currentUser, 'ListController', $status, $published);

            $this->f3->set('content', $content);
            //F3::set('taggedType', $taggedType);
            $this->f3->set('tagged', $taggedElement);
            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('published', $published);
            $this->f3->set('img', $img);
            if ($friendProfileID) {
                $this->f3->set('friendProfileID', $friendProfileID);
                $friendProfileInfoRC = Model::get('user')->load($friendProfileID);
                $this->f3->set('friendProfileInfo', $friendProfileInfoRC);
            }
            $this->renderModule('postStatus', 'post');
        }
    }

    //just implement
    public function postComment() {
        if ($this->isLogin()) {
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
            if ($tagged != 'none') {
                $countChar = strlen($tagged);
                $countCharFirst = strpos($content, $tagged);
                $content1 = substr($content, 0, $countCharFirst);
                $content2 = substr($content, $countChar + $countCharFirst);
                $content = $content1 . "_linkWith_" . $content2;
            }
            //target for count who comments to post on notification, will check later

            if ($existCommentRC) {
                $commentEntryCase = array(
                    "actor" => $currentUser->recordID,
                    "actor_name" => $actorName,
                    "content" => $content,
                    "post" => $postID,
                    "status_post" => "later",
                    "published" => $published,
                    "tagged" => $tagged
                );
            } else {
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
        } else {
            
        }
    }

    //has implement and fix logic
    public function morePostStatus() {
        if ($this->isLogin()) {
            $currentUser = $this->getCurrentUser();
            $userProfileID = $this->f3->get('SESSION.userProfileID');
            $published = $this->f3->get('POST.published');
            $userProfileRC = Model::get('user')->load($userProfileID);
            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('userProfileInfo', $userProfileRC);
            if ($currentUser->recordID == $userProfileID) {
                $statusRC = Model::get('status')->findByCondition("owner = '" . $currentUser->recordID . "' and published < '" . $published . "' LIMIT 5 ORDER BY published DESC");
            } else {
                $statusRC = Model::get('status')->findByCondition("owner = '" . $userProfileID . "' and published < '" . $published . "' LIMIT 5 ORDER BY published DESC");
            }
            if ($statusRC) {
                foreach ($statusRC as $status) {
                    $comments[($status->recordID)] = Model::get('comment')->findByCondition("post = '" . $status->recordID . "' ORDER BY published ASC LIMIT 4");
                    $numberOfComments[($status->recordID)] = Model::get('comment')->count("post = ?", array($status->recordID));
                    //get status follow
                    $likeStatus[($status->recordID)] = $this->getLikeStatus($status->recordID, $currentUser->recordID);
                    $statusFollow[($status->recordID)] = $this->getFollowStatus($status->recordID, $currentUser->recordID);
                    $postActor[($status->data->actor)] = Model::get('user')->load($status->data->actor);
                    if ($comments[($status->recordID)]) {
                        $pos = (count($comments[($status->recordID)]) < 4 ? count($comments[($status->recordID)]) : 4);
                        for ($j = $pos - 1; $j >= 0; $j--) {
                            $commentActor[$comments[($status->recordID)][$j]->data->actor] = Model::get('user')->load($comments[($status->recordID)][$j]->data->actor);
                        }
                    } else {
                        $commentActor = null;
                    }
                }
                $this->f3->set("listStatus", $statusRC);
                $this->f3->set("comments", $comments);
                $this->f3->set("numberOfComments", $numberOfComments);
                $this->f3->set("likeStatus", $likeStatus);
                $this->f3->set("statusFollow", $statusFollow);
                $this->f3->set("postActor", $postActor);
                $this->f3->set("commentActor", $commentActor);
                $this->renderModule('morePostStatus', 'post');
            } else {
                $this->renderModule('noMorePostStatus', 'post');
            }
        }
    }

    //just implement
    public function moreComment() {
        if ($this->isLogin()) {
            $statusID = str_replace("_", ":", $this->f3->get('POST.statusID'));
            if (!empty($statusID)) {
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
                'owner'         => $this->getCurrentUser()->recordID,
                'actor'         => $parentStatus->data->owner,
                'content'       => $parentStatus->data->content,
                'tagged'        => $parentStatus->data->tagged,
                /* 'taggedType'    => $old_status->data->taggedType, */
                'actorName'     => $parentStatus->data->actorName,
                'numberLike'    => '0',
                'numberComment' => $parentStatus->data->numberComment,
                'published'     => $published,
                'contentShare'  => $txtShare,
                'numberShared'  => '0',
                'numberFollow'  => '0',
                'mainStatus'    => $statusID,
                'active'        => '1',
                'img'           => false
            );

            // save
            $status = $this->facade->save('status', $postEntry);
            // track activity
            $this->trackActivity($this->getCurrentUser(), 'ListController', $status, $published);
        }
    }

    //just implement
    public function detailStatus() {
        if ($this->isLogin()) {
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

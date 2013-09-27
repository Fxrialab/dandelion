<?php
/**
 * Author: Hoc Nguyen
 * Date: 12/21/12
 */

class PostController extends AppController {

    protected $uses = array ("Friendship", "User", "Follow", "Status", "Comment", "Post","Photo");

    public function __construct() {
        parent::__construct();
    }
    //has implement and fix logic
    public function myPost($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'default';

            $requestCurrentProfile   = F3::get('GET.username');
            if($requestCurrentProfile)
            {
                $currentProfileRC   = $this->User->findOne("username = ?", array($requestCurrentProfile));
                if ($currentProfileRC)
                {
                    $currentProfileID   = $currentProfileRC->recordID;
                }else {
                    //@TODO: add layout return page not found in later
                    echo "page not found";
                }
            }else
                $currentProfileID   = $this->getCurrentUser()->recordID;
            F3::set('SESSION.userProfileID',$currentProfileID);
            $currentProfileRC   = $this->User->load($currentProfileID);
            $currentUser        = $this->getCurrentUser();
            //get status friendship
            $statusFriendShipRC = $this->Friendship->findOne('userA = ? AND userB = ?', array($currentUser->recordID, $currentProfileRC->recordID));
            $statusFriendship   = ($statusFriendShipRC == NULL) ? 'null' : $statusFriendShipRC->data->relationship;
            //set
            F3::set('currentUser', $currentUser);
            F3::set('otherUser', $currentProfileRC);

            F3::set('statusFriendShip', $statusFriendship);
            //set ID for postWrap.php
            F3::set("currentProfileID", $currentProfileID);
            // get id status of user was following.
            $getFollowRC    = $this->Follow->findOne('userA = ?  and filterFollow = ?  ',array($currentProfileID,'post'));
            /* if exist status following. Get status following and get status of this user.*/
            if($getFollowRC)
            {
                $statusRC   = $this->Status->findByCondition("owner = ? OR @rid = ? ORDER BY published DESC LIMIT 5", array($currentProfileID,$getFollowRC->data->ID));
            }else  {
                $statusRC   = $this->Status->findByCondition("owner = ? ORDER BY published DESC LIMIT 5", array($currentProfileID));
            }

            if($statusRC)
            {
                foreach ($statusRC as $status)
                {
                    $comments[($status->recordID)]        = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published DESC", array($status->recordID));
                    $numberOfComments[($status->recordID)]= $this->Comment->count("post = ?", array($status->recordID));
                    //get status follow
                    $likeStatus[($status->recordID)]    = $this->getLikeStatus($status->recordID, $currentUser->recordID);
                    $statusFollow[($status->recordID)]  = $this->getFollowStatus($status->recordID, $currentUser->recordID);
                    //get info user actor
                    $postActor[($status->data->actor)]    = $this->User->load($status->data->actor);
                    if ($comments[($status->recordID)])
                    {
                        $pos = (count($comments[($status->recordID)]) < 4 ? count($comments[($status->recordID)]) : 4);
                        for($j = $pos - 1; $j >= 0; $j--)
                        {
                            $commentActor[$comments[($status->recordID)][$j]->data->actor] = $this->User->load($comments[($status->recordID)][$j]->data->actor);
                        }
                    }else {
                        $commentActor = null;
                    }
                }

                F3::set("listStatus", $statusRC);
                F3::set("comments", $comments);
                F3::set("numberOfComments", $numberOfComments);
                F3::set("likeStatus", $likeStatus);
                F3::set("statusFollow", $statusFollow);
                F3::set("postActor", $postActor);
                F3::set("commentActor",$commentActor);
            }
            $this->render($viewPath.'myPost.php','modules');
        }else {

        }
    }
    //just implement
    public function loadComment($object,$actor,$activityID)
    {
        if($this->isLogin())
        {
            $findStatus = $this->Comment->findByCondition("@rid = ?", array('#'.$object));
            //var_dump($findStatus);
            if($findStatus)
            {
                $findContentStt =  $this->Status->findByCondition("@rid = ?",array('#'.$findStatus[0]->data->post));
                $lengthComment  = strlen($findContentStt[0]->data->content);
                $contentStatusDisplay = ($lengthComment > 40) ? str_replace(substr($findContentStt[0]->data->content, 40), '...', $findContentStt[0]->data->content) : $findContentStt[0]->data->content;
                $profileCommentActor[$actor] = $this->User->load($actor);
                $entry = array(
                    'activityID'    => $activityID,
                    'currentUser'   => $this->getCurrentUser(),
                    'name'          => $findStatus[0]->data->actor_name,
                    'pfCommentActor'=> $profileCommentActor,
                    'content'       => $contentStatusDisplay,
                    'numberComment' => $findContentStt[0]->data->numberComment,
                    'published'     => $findStatus[0]->data->published,
                    'text'          => 'has comment ',
                    'actor'         => $actor,
                    'commentID'     => $object,
                    'owner'         => $findContentStt[0]->data->owner,
                    'link'          => 'detailStatus?id='.$findStatus[0]->data->post,
                    'type'          => 'status',
                    'contentCmt'    => $findStatus[0]->data->content,
                    'tagged'        => $findContentStt[0]->data->tagged,
                    'path'          => Register::getPathModule('post'),
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
            $published          = time();
            $currentUser        = $this->getCurrentUser();
            $friendProfileID    = F3::get('SESSION.userProfileID');
            $taggedElement      = F3::get("POST.fullURL");
            //@TODO: check type of tagged later
            //$taggedType         = F3::get("POST.taggedType");
            $content            = F3::get("POST.status");

            if($taggedElement != 'none')
            {
                $countChar  = strlen($taggedElement);
                $countCharFirst = strpos($content,$taggedElement);
                $content1   = substr($content,0,$countCharFirst);
                $content2   = substr($content,$countChar + $countCharFirst);
                $content    = $content1."_linkWith_". $content2;
            }
            // prepare data
            $postEntry = array(
                'owner'         => F3::get("POST.profileID"),
                'actor'         => $currentUser->recordID,
                'content'       => $content,
                'tagged'        => $taggedElement,
                /*'taggedType'    => $taggedType,*/
                'actorName'     => $this->getCurrentUserName(),
                /*'lastTwoComment'=> '',*/
                'numberLike'    => '0',
                'numberComment' => '0',
                'published'     => $published,
                'numberShared'  => '0',
                'contentShare'  => '',
                'numberFollow'  => '0',
                'mainStatus'    => 'none',
            );

            // save
            $status = $this->Status->create($postEntry);
            //$this->Post->createEdge('#'.$status,'#'.$currentUser->recordID);
            F3::set('statusID',$status);
            // track activity
            $this->trackActivity($currentUser, 'HomePost', $status, $published);

            F3::set('content', $content);
            //F3::set('taggedType', $taggedType);
            F3::set('tagged', $taggedElement);
            F3::set('currentUser', $currentUser);
            F3::set('published', $published);
            if($friendProfileID){
                //@TODO: assign to Loc: check lai su dung friendProfileInfo de lay ID thay vi phai set them cho friendProfileID
                F3::set('friendProfileID', $friendProfileID);
                $friendProfileInfoRC = $this->User->load($friendProfileID);
                F3::set('friendProfileInfo',$friendProfileInfoRC);
            }
            $this->renderModule('postStatus','post');
        }
    }
    //just implement
    public function postComment()
    {
        if ($this->isLogin())
        {
            $currentUser    = $this->getCurrentUser();
            $postID         = str_replace("_", ":", F3::get('POST.postID'));
            $actorName      = $this->getCurrentUserName();
            $published      = time();
            //@todo: fix here
            $existCommentRC = $this->Comment->findByCondition("actor = ? AND post = ?", array($currentUser->recordID, $postID));
            //prepare data
            $content    = F3::get('POST.comment');
            $URL        = F3::get('POST.fullURL');
            $tagged     = ($URL == 'undefined') ? 'none' : $URL;
            if($tagged != 'none')
            {
                $countChar  = strlen($tagged);
                $countCharFirst = strpos($content,$tagged);
                $content1   = substr($content,0,$countCharFirst);
                $content2   = substr($content,$countChar + $countCharFirst);
                $content    = $content1."_linkWith_". $content2;
            }
            if($existCommentRC)
            {
                $commentEntryCase1 = array(
                    "actor"         => $currentUser->recordID,
                    "actor_name"    => $actorName,
                    "content"       => $content,
                    "post"          => $postID,
                    "status_post"   => "later",
                    "published"     => $published,
                    "tagged"        => $tagged
                );

                $commentRC  = $this->Comment->create($commentEntryCase1);
                /*$this->Post->createEdge('#'.$commentRC, '#'.$postID);
                $this->Post->createEdge('#'.$currentUser->recordID, '#'.$commentRC);*/
                $commentID  = $commentRC;
            }else {
                $commentEntryCase2 = array(
                    "actor"         => $currentUser->recordID,
                    "actor_name"    => $actorName,
                    "content"       => $content,
                    "post"          => $postID,
                    "status_post"   => "first",
                    "published"     => $published,
                    "tagged"        => $tagged
                );
                $commentRC  = $this->Comment->create($commentEntryCase2);
                /*$this->Post->createEdge('#'.$commentRC, '#'.$postID);
                $this->Post->createEdge('#'.$currentUser->recordID, '#'.$commentRC);*/
                $commentID  = $commentRC;
            }
            /* Update number comment */
            $status_update = $this->Status->findOne('@rid = ?',array('#'.$postID));
            $dataCountNumberComment = array(
                'numberComment'     => $status_update->data->numberComment +1
            );
            $this->Status->updateByCondition($dataCountNumberComment, "@rid = ?", array("#".$postID));

            // track activity
            $userPostID = $this->Status->findOne("@rid = ?",array($postID));
            $this->trackComment($currentUser, "post".$commentID, $commentID, $postID,$userPostID->data->actor, $published); //commentHoc SAVE Activity follow object is ID comment

            // data for ajax
            F3::set('published', $published);
            F3::set('content', $content);
            F3::set('currentUser', $currentUser);
            F3::set('postID', $postID);
            F3::set('tagged',$tagged);

            $this->renderModule('postComment','post');
        }else {

        }
    }
    //has implement and fix logic
    public function morePostStatus()
    {
        if ($this->isLogin())
        {
            $currentUser    = $this->getCurrentUser();
            $userProfileID  = F3::get('SESSION.userProfileID');
            $published      = F3::get('POST.published');
            $userProfileRC  = $this->User->load($userProfileID);
            F3::set('currentUser', $currentUser);
            F3::set('userProfileInfo', $userProfileRC);
            if($currentUser->recordID == $userProfileID)
            {
                $statusRC   = $this->Status->findByCondition("owner = ? and published < ? LIMIT 5 ORDER BY published DESC", array($currentUser->recordID, $published));
            }else {
                $statusRC   = $this->Status->findByCondition("owner = ? and published < ? LIMIT 5 ORDER BY published DESC", array($userProfileID, $published));
            }
            if($statusRC)
            {
                foreach ($statusRC as $status)
                {
                    $comments[($status->recordID)] = $this->Comment->findByCondition("post = ? ORDER BY published ASC LIMIT 4", array($status->recordID));
                    $numberOfComments[($status->recordID)] = $this->Comment->count("post = ?", array($status->recordID));
                    //get status follow
                    $likeStatus[($status->recordID)]    = $this->getLikeStatus($status->recordID, $currentUser->recordID);
                    $statusFollow[($status->recordID)]  = $this->getFollowStatus($status->recordID, $currentUser->recordID);
                    $postActor[($status->data->actor)]  = $this->User->load($status->data->actor);
                    if ($comments[($status->recordID)])
                    {
                        $pos = (count($comments[($status->recordID)]) < 4 ? count($comments[($status->recordID)]) : 4);
                        for($j = $pos - 1; $j >= 0; $j--)
                        {
                            $commentActor[$comments[($status->recordID)][$j]->data->actor] = $this->User->load($comments[($status->recordID)][$j]->data->actor);
                        }
                    }else {
                        $commentActor = null;
                    }
                }
                F3::set("listStatus", $statusRC);
                F3::set("comments", $comments);
                F3::set("numberOfComments", $numberOfComments);
                F3::set("likeStatus", $likeStatus);
                F3::set("statusFollow", $statusFollow);
                F3::set("postActor", $postActor);
                F3::set("commentActor",$commentActor);

                $this->renderModule('morePostStatus','post');
            }else {
                $this->renderModule('noMorePostStatus','post');
            }
        }else {

        }
    }
    //just implement
    public function morePostComment()
    {
        if ($this->isLogin()) {
            $requestProfileID = F3::get('POST.id');

            $profileID = ($requestProfileID == NULL) ? $this->getCurrentUser()->recordID : $requestProfileID;
            $published = F3::get('POST.published');
            $statusID = str_replace("_", ":",  F3::get('POST.statusID'));
            //because layout for public photo different with status. Must render to view photo show more comment
            $ClusterIDPhoto = $this->Photo->getClusterID();
            $checkPhoto = str_replace(substr($statusID, strpos($statusID, ':')), '', $statusID);

            if ($profileID) {
                $comments = $this->Comment->findByCondition("post = ? and published < ? LIMIT 50 ORDER BY published DESC", array($statusID, $published));
                $numberOfRemainingComments = $this->Comment->count("post = ? and published < ?", array($statusID, $published));
                if ($comments)
                {
                    $pos = (count($comments) < 50 ? count($comments) : 50);
                    for($j = $pos - 1; $j >= 0; $j--)
                    {
                        $commentActor[$comments[$j]->data->actor] = $this->User->load($comments[$j]->data->actor);
                    }
                }else {
                    $commentActor = null;
                }
                F3::set("commentActor",$commentActor);
                F3::set("comments", $comments);
                F3::set('nameClassElement', F3::get('POST.nameClass'));
                if (count($comments) >= $numberOfRemainingComments) {
                    if($ClusterIDPhoto == $checkPhoto) {
                       // echo F3::render("photo/ajax_more_comment.php");
                    }else {
                        //echo F3::render("activity/ajax_more_comment.php");
                        $this->renderModule('morePostComment','post');
                        //  $this->renderAction('ajax_more_comment','post'); in old source
                    }

                    F3::set("id", F3::get('POST.statusID'));
                    if($ClusterIDPhoto == $checkPhoto) {
                        //echo F3::render("photo/ajax_no_more_comment.php");
                    }else {
                        //echo F3::render("activity/ajax_no_more_comment.php");
                        $this->renderModule('morePostComment','post');
                        // $this->renderAction('ajax_more_comment','post'); in old source
                    }
                }
                else
                {
                    if($ClusterIDPhoto == $checkPhoto) {
                        //echo F3::render("photo/ajax_more_comment.php");
                    }else {
                       // echo F3::render("activity/ajax_more_comment.php");
                        $this->renderModule('morePostComment','post');
                        // $this->renderAction('ajax_more_comment','post'); in old source
                    }
                }
            }
        }
    }
    //just implement
    public function shareStatus()
    {
        if($this->isLogin()){
            $status_id = F3::get('POST.status_id');
            $content_stt = $this->Status->findOne("@rid = ?",array($status_id));
            $getAvatar = $this->User->findOne(" @rid = ? ",array($content_stt->data->owner));
            F3::set('content_stt',$content_stt);
            F3::set('getAvatar',$getAvatar);
            $this->renderModule('shareStatus','post');
        }
    }
    //just implement
    public function insertStatus()
    {
        if($this->isLogin()){
            $published = time();
            $rid = F3::get("POST.rid");
            $content = F3::get("POST.status");
            $old_status = $this->Status->findOne("@rid = ?",array($rid));
            $old_status->data->numberShared = $old_status->data->numberShared +1;
            $this->Status->update($rid,$old_status);
            $postEntry = array(
                'owner'         => $this->getCurrentUser()->recordID,
                'actor'         => $old_status->data->owner,
                'content'       => $old_status->data->content,
                'tagged'        => $old_status->data->tagged,
                /*'taggedType'    => $old_status->data->taggedType,*/
                'actorName'     => $old_status->data->actorName,
                'numberLike'    => '0',
                'numberComment' => $old_status->data->numberComment,
                'published'     => $published,
                'contentShare'  => $content,
                'numberShared'  => '0',
                'numberFollow'  => '0',
                'mainStatus'    =>$rid,
            );

            // save
            $status = $this->Status->create($postEntry);

            // track activity
            $this->trackActivity($this->getCurrentUser(), 'HomePost', $status, $published);
        }

    }
    //just implement
    public function detailStatus()
    {
          if($this->isLogin())
          {
              $this->layout = 'default';
              $statusID = F3::get('GET.id');
              $status = $this->Status->load($statusID);
              $comment = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published ASC", array($statusID));
              $userFriend = $this->User->findOne("@rid = ?",array($status->data->owner));
              $getStatusFollow = $this->Follow->findOne("userA = ? AND userB = ? AND filterFollow = 'post' AND ID = ?", array($status->data->owner, $status->data->actor, $statusID));
              $statusFollow    = ($getStatusFollow == null) ? 'null' : $getStatusFollow->data->follow;
              $currentUser        = $this->getCurrentUser();
              F3::set('statusFollow',$statusFollow);
              //F3::set('username', ucfirst($this->getCurrentUser()->data->firstName) . " " . ucfirst($this->getCurrentUser()->data->lastName));
              F3::set('currentUser', $currentUser);
              F3::set('otherUser', $currentUser);
              F3::set('userFriend',$userFriend);
              F3::set('comment',$comment);
              F3::set('status_detail',$status);
              $this->render(Register::getPathModule('post').'detailStatus.php','modules');
          }
    }

}
?>
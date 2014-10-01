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

    public function bindingData($entry, $key)
    {
        if (!empty($entry))
        {
            $currentUser= $this->getCurrentUser();
            $statusRC   = $this->facade->findByAttributes('status', array('@rid'=>'#'.$entry->data->object, 'active'=>1));

            if (!empty($statusRC))
            {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $this->facade->findByPk("user", $statusRC->data->owner);

                $like = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID,'objID'=>$statusID));
                $entry = array(
                    'type'      => 'post',
                    'key'       => $key,
                    'like'      => $like,
                    'user'      => $userRC,
                    'username'  => $userRC->data->username,
                    'profilePic'=> $userRC->data->profilePic,
                    'actions'   => $statusRC,
                    'objectID'  => $statusID,
                    'path'      => Register::getPathModule('post'),
                );
                return $entry;
            }else{
                return false;
            }
        }else {
            return false;
        }
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
                $this->render($viewPath . 'mains/myPost.php', 'modules', array(
                    'currentUser'   => $currentUser,
                    'otherUser'     => $currentProfileRC,
                    'statusFriendShip'  => $statusFriendShip,
                    'currentProfileID'  => $currentProfileID,
                ));
            }
        }
    }

    /**
     *  This is loading only post on post module
     */
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
                    $this->renderModule('mains/post', 'post', array('listStatus'=>$statusRC, 'likeStatus'=>$likeStatus));
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
            //typeID is available with group module
            if (!empty($_POST['typeID']))
                $typeID = $_POST['typeID'];
            else
                $typeID = FALSE;
            // prepare data
            if (!$embedType || $embedType == 'none')
            {
                $embedSource = false;
            }
            else
            {
                if ($embedType == 'photo')
                {
                    $imagesDir = UPLOAD . "images/";
                    $images = $_POST["imgName"];
                    foreach ($images as $image)
                    {
                        //images are waiting in tmp folder
                        $file = UPLOAD.'tmp/'.$image;
                        list($width, $height) = getimagesize($file);
                        //check IF size of images are larger than 960px then resize us ELSE move us from tmp folder to images folder
                        if ($width > 960 || $height > 960)
                            $this->resizeImageFile($file, 960, $imagesDir.$image, 100);
                        else
                            rename($file, $imagesDir.$image);
                        //save to DB
                        list($nWidth, $nHeight) = getimagesize(UPLOAD.'images/'.$image);
                        $entry = array(
                            'owner' => $currentUser->recordID,
                            'albumID' => 'none',
                            'fileName' => $image,
                            'width' => $nWidth,
                            'height' => $nHeight,
                            'dragX' => '0',
                            'dragY' => '0',
                            'thumbnail_url' => '',
                            'description' => '',
                            'numberLike' => '0',
                            'numberComment' => '0',
                            'statusUpload' => 'uploaded',
                            'published' => time(),
                            'type' => 'none'
                        );
                        $this->facade->save('photo', $entry);
                    }
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

            $postEntry = array(
                'owner' => $this->f3->get('SESSION.userID'),
                'actor' => $currentUser->recordID,
                'content' => $content,
                'embedType' => $embedType,
                'embedSource'   => $embedSource,
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
            $this->trackActivity($currentUser, 'Post', $statusID, $type, $typeID, $published);

            $status = $this->facade->findByPk('status', $statusID);
            $this->f3->set('status', $status);
            $this->f3->set('statusID', $statusID);
            $this->f3->set('content', $content);
            //$this->f3->set('tagged', 'none');
            $this->f3->set('currentUser', $currentUser);
            $this->f3->set('published', $published);
            $this->renderModule('mains/postStatus', 'post');
        }
    }

    //just implement
    public function postComment()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $postID = str_replace("_", ":", $this->f3->get('POST.postID'));
            $published = time();

            //prepare data
            $content = $this->f3->get('POST.comment');
            //target for count who comments to post on notification, will check later
            $commentEntryCase = array(
                "userID" => $currentUser->recordID,
                "content" => $content,
                "typeID" => $postID,
                "published" => $published,
                'numberLike' => 0
            );
            $commentID = $this->facade->save('comment', $commentEntryCase);
            $commentRC = $this->facade->findByPk('comment', $commentID);
            /* Update number comment */
            $status_update = $this->facade->findByAttributes('status', array('@rid' => '#' . $postID));
            $dataCountNumberComment = array(
                'numberComment' => $status_update->data->numberComment + 1
            );
            $this->facade->updateByAttributes('status', $dataCountNumberComment, array('@rid' => "#" . $postID));
            //sent a notifications to owner's status
            $owner  =   $status_update->data->owner;
            $duplicate = $this->facade->findByAttributes('activity', array('owner'=>$owner, 'verb'=>'comment', 'object'=>$postID));
            if (empty($duplicate))
            {
                //create a activity for owner's status
                $entry = array(
                    'owner' => $owner,
                    'actor' => $currentUser->recordID,
                    'verb' => 'comment',
                    'object'=> $postID,
                    'type'  => 'notifications',
                    'timers' => $published,
                    'details'   => 'commented on your status',
                );
                $this->facade->save('activity', $entry);
                //update to notify class
                $curNotify = $this->facade->findByAttributes('notify', array('userID'=>$owner));
                $updateNotify = array(
                    'notifications' => $curNotify->data->notifications + 1,
                );
                $this->facade->updateByAttributes('notify', $updateNotify, array('userID'=>$owner));
                //sent a notifications
                $newNotify = $this->facade->findByAttributes('notify', array('userID'=>$owner));
                $notifications = $newNotify->data->notifications;
                $keys = 'notifications.comment.'.$owner;
                $keys = str_replace(':','_', $keys);
                $data = array(
                    'type'  => 'comment',
                    'target'=> str_replace(':', '_',$postID),
                    'dispatch'  => str_replace(':', '_',$currentUser->recordID),
                    'content'   => $content,
                    'published'  => $published,
                    'count' => $notifications,
                );
                $this->service->exchange('dandelion','topic')->routingKey($keys)->dispatch('comment', $data);
            }else {//else update it
                $actor = explode('_',$duplicate->data->actor);
                $pos = array_search($currentUser->recordID, $actor);
                if (!is_bool($pos))
                {
                    unset($actor[$pos]);
                }
                $str = '';
                if(count($actor) >= 1)
                {
                    foreach ($actor as $actors)
                    {
                        $str = $str.$actors.'_';
                    }
                    $str = substr($currentUser->recordID.'_'.$str, 0, -1);
                }elseif (count($actor) == 0){
                    $str = $str.$currentUser->recordID;
                }
                //then create a activity for who's friend join to status
                $curActor = explode('_',$duplicate->data->actor);
                $ownerName = HelperController::getFullNameUser($owner);
                foreach ($curActor as $a)
                {
                    if ($a != $currentUser->recordID)
                    {
                        $actorActivity = $this->facade->findByAttributes('activity', array('owner'=>$a, 'verb'=>'comment', 'object'=>$postID));
                        if (empty($actorActivity))
                        {
                            $entry = array(
                                'owner' => $a,
                                'actor' => $str,
                                'verb' => 'comment',
                                'object'=> $postID,
                                'type'  => 'notifications',
                                'timers' => $published,
                                'details'   => "also commented on ".$ownerName."'s status",
                            );
                            $this->facade->save('activity', $entry);
                        }else {
                            $actorActivity->data->actor = $str;
                            $actorActivity->data->timers = $published;
                            $this->facade->updateByPk('activity', $actorActivity->recordID, $actorActivity);
                        }
                        //update to notify class
                        $curNotify = $this->facade->findByAttributes('notify', array('userID'=>$a));
                        $updateNotify = array(
                            'notifications' => $curNotify->data->notifications + 1,
                        );
                        $this->facade->updateByAttributes('notify', $updateNotify, array('userID'=>$a));
                        //sent a notifications
                        $newNotify = $this->facade->findByAttributes('notify', array('userID'=>$a));
                        $notifications = $newNotify->data->notifications;
                        $keys = 'notifications.comment.'.$a;
                        $keys = str_replace(':','_', $keys);
                        $data = array(
                            'type'  => 'comment',
                            'target'=> str_replace(':', '_',$postID),
                            'dispatch'  => str_replace(':', '_',$currentUser->recordID),
                            'content'   => $content,
                            'published'  => $published,
                            'count' => $notifications,
                        );
                        $this->service->exchange('dandelion','topic')->routingKey($keys)->dispatch('comment', $data);
                    }
                }

                //update actors to owner's status
                $duplicate->data->actor = $str;
                $duplicate->data->timers = $published;
                $this->facade->updateByPk('activity', $duplicate->recordID, $duplicate);
            }

            $this->f3->set('comments', $commentRC);

            $this->renderModule('mains/viewComment', 'post');
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
                $comments = $this->facade->findAllAttributes('comment', array('typeID' => $statusID));
                $this->f3->set("comments", $comments);
                $this->renderModule('mains/moreComment', 'post');
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
            $this->renderModule('mains/shareStatus', 'post');
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
            $this->trackActivity($this->getCurrentUser(), 'Post', $status, $parentStatus->data->type, $parentStatus->data->typeID, $published);
        }
    }

}

?>

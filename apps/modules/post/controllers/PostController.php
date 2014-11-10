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
            $currentUser = $this->getCurrentUser();
            if (!empty($entry->data->object))
                $id = $entry->data->object;
            else
                $id = $entry->recordID;
            $statusRC = $this->facade->findByAttributes('status', array('@rid' => '#' . $id, 'active' => 1));

            if (!empty($statusRC))
            {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $this->facade->findByPk("user", $statusRC->data->owner);

                $like = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $statusID));
                $photo = $this->facade->findAllAttributes('photo', array('typeID' => $statusRC->recordID));
                $comment = $this->facade->findAllAttributes('comment', array('typeID' => $statusRC->recordID));
                $commentArray = array();
                if (!empty($comment))
                {
                    foreach ($comment as $value)
                    {
                        $userComment = $this->facade->findByPk("user", $value->data->owner);
                        $likeComment = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $value->recordID));
                        $commentArray[] = array('comment' => $value, 'user' => $userComment, 'like' => $likeComment);
                    }
                }
                $entry = array(
                    'type' => 'post',
                    'key' => $key,
                    'like' => $like,
                    'user' => $userRC,
                    'photo' => $photo,
                    'comment' => $commentArray,
                    'actions' => $statusRC,
//                    'path' => Register::getPathModule('post'),
                );
                return $entry;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
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
                $obj->type = 'post';
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
                    $this->renderModule('post', 'post', array('listStatus' => $statusRC, 'likeStatus' => $likeStatus));
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


            $postEntry = array(
                'owner' => $this->f3->get('SESSION.userID'),
                'actor' => $currentUser->recordID,
                'content' => $content,
                'embedType' => $embedType,
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
                        $file = UPLOAD . str_replace(':', '', $this->f3->get('SESSION.userID')) . '/' . $image;
                        list($width, $height) = getimagesize($file);
//                        //check IF size of images are larger than 960px then resize us ELSE move us from tmp folder to images folder
//                        if ($width > 960 || $height > 960)
//                            $this->resizeImageFile($file, 960, $imagesDir . $image, 100);
//                        else
//                            rename($file, $imagesDir . $image);
//                        //save to DB
//                        list($nWidth, $nHeight) = getimagesize(UPLOAD . 'images/' . $image);
                        $entry = array(
                            'owner' => $currentUser->recordID,
                            'albumID' => 'none',
                            'typeID' => $statusID,
                            'fileName' => $image,
                            'width' => $width,
                            'height' => $height,
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
            // track activity
            $this->trackActivity($currentUser, 'Post', $statusID, $type, $typeID, $published);

            $status = $this->facade->findByPk('status', $statusID);
            $photo = $this->facade->findAllAttributes('photo', array('typeID' => $status->recordID));
            $data = array('status' => $status, 'photo' => $photo, 'user' => $currentUser);
            $this->renderModule('postStatus', 'post', array('data' => $data));
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
            $this->trackActivity($this->getCurrentUser(), 'Post', $status, $parentStatus->data->type, $parentStatus->data->typeID, $published);
        }
    }

}

?>

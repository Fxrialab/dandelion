<?php
class PhotoController extends AppController {
    protected $uses = array("Activity" ,"Album", "Photo", "Comment", "User", "Follow","Status");
    protected $helpers = array("Array", "Pagination", "Upload");
    protected $paginationConfig = array(
        "entries_per_page" => 12,
        "navigation" => 5
    );

    public function index()
    {
        $this->layout = "default";
        $this->render("photo/index.php",'normal');
    }
    /*public function viewAlbum($viewPath) {
        if ($this->isLogin()) {

            $getAlbum_id    = F3::get("GET.id");
            $album_id       = str_replace("_", ":", $getAlbum_id);

            //echo $album_id;
            if ($this->isEnoughPermissionToAccess($album_id)) {
                $this->layout = "default";
                F3::set('username', ucfirst($this->getCurrentUser()->data->firstName) . " " . ucfirst($this->getCurrentUser()->data->lastName));
                $photos = $this->Photo->find("album  = ?", array($album_id));

                F3::set('album_id', $getAlbum_id);
                F3::set("photos", $photos);
                $this->render($viewPath."index.php",'modules');
            }
        }

    }*/

    public function viewAlbum()
    {
        if ($this->isLogin())
        {
            $this->layout   =   "default";
            $getAlbum_id    = F3::get("GET.id");
            $album_id       = str_replace("_", ":", $getAlbum_id);
            if ($album_id)
            {
                F3::set('username', ucfirst($this->getCurrentUser()->data->firstName) . " " . ucfirst($this->getCurrentUser()->data->lastName));
                $photos         = $this->Photo->findByCondition("album  = ?", array($album_id));
                $currentUser    =   $this->getCurrentUser();
                F3::set('album_id', $getAlbum_id);
                F3::set("photos", $photos);
                F3::set('currentUser', $currentUser);
                F3::set('otherUser', $currentUser);
            }
            $this->render(Register::getPathModule('photo').'index.php','modules');
        }

    }


    public function uploadPhoto()
    {
        switch ($_SERVER['REQUEST_METHOD'])
        {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $this->UploadHelper->get();
                break;
            case 'POST':
                if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $this->UploadHelper->delete();
                } else {
                    $uploadRequestData = json_decode($this->UploadHelper->post());
                    $data = $uploadRequestData[0];
                    // @todo: research about F3 bugs here, F3::get("REQUEST") don't work?
                    $album_id = ($_REQUEST["album_id"]) ? str_replace("_", ":",  $_REQUEST["album_id"]) : "";
                    $description = F3::get('description') ?  F3::get('description') : "";
/*                    $description    =   F3::get("POST.descriptionPhoto");*/
                    //mo ta rieng cho tung anh

                    $published = time();
                   $url = $data->url;
                    echo($url);
                    $entry = array(
                        'owner' => $this->getCurrentUser()->recordID,
                        'album' => $album_id,
                        'url' => $data->url,
                        'thumbnail_url' => $data->thumbnail_url,
                        'description' => $description,
                        'numberComment' => '0',
                        'published' => $published
                    );
                    $Photo = $this->Photo->create($entry);
                    F3::set('photo',$Photo);
                    F3::set('description',$description);
                    //track activity
                    $this->trackActivity($this->getCurrentUser(), 'HomePhoto', $Photo, $published);
                }
                break;
            case 'DELETE':
                $this->UploadHelper->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
    }

    // @todo: ask client for album page
    public function myPhoto($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout               = "default";
            $requestCurrentProfile      = F3::get('GET.username');
            if($requestCurrentProfile)
            {
                $currentProfileRC       = $this->User->findOne("username = ?", array($requestCurrentProfile));
                if ($currentProfileRC)
                    $currentProfileID   = $currentProfileRC->recordID;
                else
                    echo "page not found";
            }
            else
                $currentProfileID       = $this->getCurrentUser()->recordID;
            F3::set('username', ucfirst($this->getCurrentUser()->data->firstName) . " " . ucfirst($this->getCurrentUser()->data->lastName));
            $pageNum = F3::get('GET.pageNum');
            if (empty($pageNum))
                $pageNum = 1;
            $requestProfileID = F3::get('GET.id');
            $profileID = ($requestProfileID == NULL) ? $this->getCurrentUser()->recordID : $this->User->getClusterID() . ":" .$requestProfileID;
            $nameProfile        = $this->User->findOne('@rid = ?',array('#'.$profileID));
            $currentUser        = $this->getCurrentUser();//user login
            $statusFriendShip   = $this->Friendship->findOne('userA = ? AND userB = ?', array($currentUser->recordID, $nameProfile->recordID));
            $status             = ($statusFriendShip == NULL) ? 'null' : $statusFriendShip->data->relationship;
            $currentProfileRC   = $this->User->load($currentProfileID);
            F3::set('currentUser', $this->getCurrentUser());
            F3::set('otherUser', $currentProfileRC);
            F3::set('profileUser', ucfirst($nameProfile->data->firstName)." ".ucfirst($nameProfile->data->lastName));
            F3::set('userID', $currentUser);
            F3::set('friendID', $nameProfile);
            F3::set('statusFriendShip', $status);
            $albums     = $this->Album->findByCondition('owner = ? ORDER BY published DESC', array($profileID));
            $photos     = $this->Photo->findByCondition('owner = ? AND album = ? ORDER BY published DESC', array($profileID, ""));

            if($albums)
            {
                foreach($albums as $getAlbums)
                {
                    $firstPhotoOfAlbum[($getAlbums->recordID)]      = $this->Photo->findByCondition("album = ? LIMIT 1 ORDER BY published DESC", array($getAlbums->recordID));
                    $numberPhotosOfAlbum[($getAlbums->recordID)]    = $this->Photo->findByCondition("album = ?", array($getAlbums->recordID));
                    $numberPhotos       = ($numberPhotosOfAlbum[($getAlbums->recordID)]) ? count($numberPhotosOfAlbum[($getAlbums->recordID)]) : 0;
                    $updateCountPhotos  = array(
                        'count'         => $numberPhotos
                    );
                    $this->Album->updateByCondition($updateCountPhotos, "@rid = ?", array("#".$getAlbums->recordID));
                }

                F3::set('firstPhoto', $firstPhotoOfAlbum);
            }
            F3::set('albums', $albums);
            F3::set('photos',$photos);
            $this->render($viewPath."album.php",'modules');
        }
    }

    public function myAlbum()
    {
        if($this->isLogin())
        {
            $this->layout       =   'default';
            $requestProfileID   = F3::get('GET.id');
            $profileID          = ($requestProfileID == NULL) ? $this->getCurrentUser()->recordID : $this->User->getClusterID() . ":" .$requestProfileID;
            $currentUser        =   $this->getCurrentUser();
            $albums             = $this->Album->findByCondition('owner = ? ORDER BY published DESC', array($profileID));
            if($albums)
            {
                foreach($albums as $getAlbums)
                {
                    $firstPhotoOfAlbum[($getAlbums->recordID)]      = $this->Photo->findByCondition("album = ? LIMIT 1 ORDER BY published DESC", array($getAlbums->recordID));
                    $numberPhotosOfAlbum[($getAlbums->recordID)]    = $this->Photo->findByCondition("album = ?", array($getAlbums->recordID));
                    $numberPhotos       = ($numberPhotosOfAlbum[($getAlbums->recordID)]) ? count($numberPhotosOfAlbum[($getAlbums->recordID)]) : 0;
                    $updateCountPhotos  = array(
                        'count'         => $numberPhotos
                    );
                    $this->Album->updateByCondition($updateCountPhotos, "@rid = ?", array("#".$getAlbums->recordID));
                }

                F3::set('firstPhoto', $firstPhotoOfAlbum);
            }
            F3::set('album',$albums);
            F3::set('currentUser', $currentUser);
            F3::set('otherUser', $currentUser);
            $this->render(Register::getPathModule('photo').'viewAlbum.php','modules');
        }
    }

    public function createAlbum()
    {
        // @todo: checck for duplicate album name, needed?
        if ($this->isLogin())
        {
            $name           = F3::get("POST.titleAlbum");
            $description    = F3::get("POST.descriptionAlbum");
            $published      = time();
            $data           = array(
                'owner'         => $this->getCurrentUser()->recordID,
                'name'          => $name,
                'description'   => $description,
                'published'     => $published,
                'cover'         => F3::get("STATIC") . "images/no-image.jpg",
                'count'         => 0
            );
            $album          =   $this->Album->create($data);
            echo $album;
        }
    }

    public function viewPhoto(){
        if ($this->isLogin()) {
            $this->layout   = 'default';
            $clientAlbumID  =   "";
            F3::set('username', ucfirst($this->getCurrentUser()->data->firstName) . " " . ucfirst($this->getCurrentUser()->data->lastName));

            $photoID        = $this->Photo->getClusterID() . ':' . F3::get('GET.photoID');
            $albumID        = $this->Photo->getClusterID() . ':' . F3::get("GET.albumID");
            if(F3::get('GET.albumID') != '')
            {
                $album          = $this->Photo->findByCondition('@rid= ? ', array($albumID));

                for($i=0;$i<count($album);$i++)
                {
                    $id = $album[$i]->data->album;
                }
                $clientAlbumID  =    str_replace(':','_',$id);
            }
            $getAlbumID       = F3::get('GET.albumID');
            $check          = F3::get('GET.photoID');
            if($check != '') {
               $photos         =$this->Photo->findByCondition('album = ?', array(''));
                //@todo  check khi co nhieu user dang anh, chi view anh cua user current
            }else{
                $photos       =$this->Photo->findByCondition('album = ? ',array($id));
            }
            $view                = ($getAlbumID == NULL) ? $check: $getAlbumID;
            foreach($photos as $key=>$photo)
            {
                $id =    substr($photo->recordID,strpos($photo->recordID,':')+1);
                if($view == $id)
                {
                    F3::set('key',$key);
                }
            }
            F3::set("numberPhoto", count($photos));

            $preparedPhotosData = array();
            $preloadUrls = array();
            $comments = array();

            if ($photos)
            {
                for ($i =  0; $i < count($photos); $i++)
                {
                    $id = $photos[$i]->recordID;
                    array_push($preloadUrls, $photos[$i]->data->url);
                    array_push($preparedPhotosData, $this->Photo->export($photos[$i]));
                    $comments[$id] = $this->Comment->findByCondition("post = ?", array($id));//load all comment co id = get photo
                }
            }
            foreach($photos as $getPhotoID)
            {
                $commentsOfPhoto[$getPhotoID->recordID] = $this->Comment->findByCondition("post = ?", array($getPhotoID->recordID));

            }
            $currentUser       =   $this->getCurrentUser();
            F3::set("photos", $photos);
            F3::set("itemPhoto",$photoID);
            F3::set("commentsOfPhoto", $commentsOfPhoto);
            F3::set("photosJson", json_encode($preparedPhotosData));
            F3::set("album_id", $clientAlbumID);
            F3::set("urlsJson", json_encode($preloadUrls));
            F3::set("commentsJson", json_encode($comments));
            F3::set('currentUser', $currentUser);
            F3::set('otherUser', $currentUser);
            $this->render(Register::getPathModule('photo').'viewPhoto.php','modules');

        }
    }




    public function addDescription()
    {
        $description    = F3::get('POST.contentDescription');
        $getPhotoID     = F3::get('POST.photoID');
        $photoID        = str_replace('_', ':', $getPhotoID);

        $updateDescription = array('description'   => $description);
        $this->Photo->updateByCondition($updateDescription, "@rid = ?", array("#".$photoID));
    }

    public function commentPhoto()
    {
        if ($this->isLogin())
        {
            $currentUser= $this->getCurrentUser();
            $postID     = str_replace("_", ":", F3::get('POST.postID'));
            $actorName  = $this->getCurrentUser()->data->firstName." ".$this->getCurrentUser()->data->lastName;
            $published  = time();
            $find       = $this->Comment->findByCondition("actor = ? AND post = ?", array($this->getCurrentUser()->recordID, $postID));
            if($find)
            {
                $commentEntryCase1  = array(
                    "actor"         => $this->getCurrentUser()->recordID,
                    "actor_name"    => $actorName,
                    "content"       => F3::get('POST.comment'),
                    "post"          => $postID,
                    "status_post"   => "later",
                    "published"     => $published
                );

                $comment1           = $this->Comment->create($commentEntryCase1);
                $commentID          = $comment1;
            }
            else
            {
                $commentEntryCase2  = array(
                    "actor"         => $this->getCurrentUser()->recordID,
                    "actor_name"    => $actorName,
                    "content"       => F3::get('POST.comment'),
                    "post"          => $postID,
                    "status_post"   => "first",
                    "published"     => $published
                );

                $comment            = $this->Comment->create($commentEntryCase2);
                $commentID          = $comment;
            }
            /*Update number comment */
            $status_update          = $this->Photo->findOne('@rid = ?',array('#'.$postID));
            $dataCountNumberComment = array('numberComment'     => $status_update->data->numberComment +1);
            $this->Photo->updateByCondition($dataCountNumberComment, "@rid = ?", array("#".$postID));
            // track activity
            $userPostID             = $this->Photo->findOne("@rid = ?",array($postID));
            $this->trackComment($this->getCurrentUser(), "photo".$commentID, $commentID,$postID,$userPostID->data->owner, $published);
            F3::set('authorName', $this->getCurrentUser()->data->firstName." ".$this->getCurrentUser()->data->lastName);
            F3::set('published', $published);
            F3::set('content', F3::get('POST.comment'));
            F3::set('authorId', $this->getCurrentUser()->recordID);
            F3::set('postID', $postID);
            F3::set('currentUser',$currentUser);
            $check = F3::get('POST.check');
            $this->renderModule('comment','photo');
        }
    }
    /* Load comment for Insert in Activity */
    //@todo Check again with album and photo.
    public function LoadComment($object,$actor,$activityID)
    {
        if($this->isLogin())
        {
            $findStatus                 = $this->Comment->findByCondition("@rid = ?", array('#'.$object));
            if($findStatus)
            {
                $findContentStt         =  $this->Photo->findByCondition("@rid = ?",array('#'.$findStatus[0]->data->post));
                $profileCommentActor[$actor]    = $this->User->load($actor);
                $entry              = array(
                    'activityID'    =>$activityID,
                    'name'          =>$findStatus[0]->data->actor_name,
                    'content'       => '<img src=\''.$findContentStt[0]->data->thumbnail_url.'\' width=\'45px\' height=\'35px\' >',
                    'numberComment' => $findContentStt[0]->data->numberComment,
                    'pfCommentActor'=> $profileCommentActor,
                    'published'     => $findStatus[0]->data->published,
                    'text'          => 'has comment ',
                    'actor'         => $actor,
                    'commentID'     => $object,
                    'owner'         => $findContentStt[0]->data->owner,
                    'link'          =>'detailStatus?id='.$findStatus[0]->data->post,
                    'type'          => 'photo'
                );
                return $entry;
            }
        }
    }
    public function deletePhoto()
    {
        if($this->isLogin())
        {
            $id_photo   =   str_replace('_',':',F3::get('POST.id_photo'));
            if($id_photo)
            {
                $this->Photo->deleteByCondition('@rid = ? ',array('#'.$id_photo));
                $this->Activity->deleteByCondition('idObject = ? ',array($id_photo));
            }
        }
    }

    public function morePhotoComment()
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
                         $this->renderModule('morePhotoComment','photo');
                    }else {
                        //echo F3::render("activity/ajax_more_comment.php");
                        $this->renderModule('morePhotoComment','photo');
                        //  $this->renderAction('ajax_more_comment','post'); in old source
                    }

                    F3::set("id", F3::get('POST.statusID'));
                    if($ClusterIDPhoto == $checkPhoto) {
                        $this->renderModule('morePhotoComment','photo');
                    }else {
                        //echo F3::render("activity/ajax_no_more_comment.php");
                        $this->renderModule('morePhotoComment','photo');
                        // $this->renderAction('ajax_more_comment','post'); in old source
                    }
                }
                else
                {
                    if($ClusterIDPhoto == $checkPhoto) {
                        //echo F3::render("photo/ajax_more_comment.php");
                    }else {
                        // echo F3::render("activity/ajax_more_comment.php");
                        $this->renderModule('morePhotoComment','photo');
                        // $this->renderAction('ajax_more_comment','post'); in old source
                    }
                }
            }
        }
    }
}
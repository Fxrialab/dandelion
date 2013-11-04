<?php
class PhotoController extends AppController {
    protected $uses = array("Activity" ,"Album", "Photo", "Comment", "User", "Follow","Status");
    protected $helpers = array("Array", "Pagination", "Upload");
    protected $paginationConfig = array(
        "entries_per_page" => 12,
        "navigation" => 5
    );

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

            $currentUser        = $this->getCurrentUser();//user login
            $currentProfileRC   = $this->User->load($currentProfileID);

            F3::set('currentUser', $currentUser);
            F3::set('otherUser', $currentProfileRC);

            $photos     = $this->Photo->findByCondition('actor = ? AND album = ? ORDER BY published DESC', array($currentProfileID, "none"));

            F3::set('photos',$photos);
            $this->render($viewPath."myPhoto.php",'modules');
        }
    }

    public function myAlbum()
    {
        if($this->isLogin())
        {
            $this->layout       =   'default';
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
            $currentUser        =   $this->getCurrentUser();
            $currentProfileRC   = $this->User->load($currentProfileID);

            F3::set('currentUser', $currentUser);
            F3::set('otherUser', $currentProfileRC);

            $albums             = $this->Album->findByCondition('owner = ? ORDER BY published DESC', array($currentProfileID));
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

            $this->render(Register::getPathModule('photo').'myAlbum.php','modules');
        }
    }

    public function viewAlbum()
    {
        if ($this->isLogin())
        {
            $this->layout   = "default";

            $currentUser    = $this->getCurrentUser();
            $getAlbumID     = F3::get("GET.albumID");
            $albumID        = str_replace("_", ":", $getAlbumID);
            if ($albumID)
            {
                $photos     = $this->Photo->findByCondition("album  = ? AND actor = ?", array($albumID, $currentUser->recordID));

                F3::set('albumID', $getAlbumID);
                F3::set("photos", $photos);
                F3::set('currentUser', $currentUser);
                F3::set('otherUser', $currentUser);
            }
            $this->render(Register::getPathModule('photo').'album.php','modules');
        }
    }


    public function loadingPhoto()
    {
        $output_dir = UPLOAD."test/";
        $data = array(
            'results'   => array(),
            'success'   => false,
            'error'     => ''
        );

        if(isset($_FILES["myfile"]))
        {
            $currentUser    = $this->getCurrentUser();
            $data['success']= true;
            $data['error']  = $_FILES["myfile"]["error"];

            if(!is_array($_FILES["myfile"]['name'])) //single file
            {
                echo "single file";
                $fileName   = $_FILES["myfile"]["name"];
                $path       = $output_dir. $fileName;
                move_uploaded_file($_FILES["myfile"]["tmp_name"],$path);
                //echo "<br> Error: ".$_FILES["myfile"]["error"];

                $entry = array(
                    'actor'         => $currentUser->recordID,
                    'album'         => '',
                    'url'           => UPLOAD_URL."test/".$fileName,
                    'thumbnail_url' => '',
                    'description'   => '',
                    'numberComment' => '0',
                    'statusUpload'  => 'uploading',
                    'published'     => ''
                );
                $this->Photo->create($entry);
                //get recordID of each photo for pass other info
                $infoPhotoRC    = $this->Photo->findOne("actor = ? AND statusUpload = 'uploading'", array($currentUser->recordID));
                $data['results'][]  = array(
                    'photoID'   => str_replace(':', '_', $infoPhotoRC->recordID),
                    'fileName'  => $infoPhotoRC->data->fileName,
                    'url'       => $infoPhotoRC->data->url,
                );
            }
            else
            {
                $fileCount = count($_FILES["myfile"]['name']);
                for($i=0; $i < $fileCount; $i++)
                {
                    $fileName = $_FILES["myfile"]["name"][$i];
                    move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName );

                    $entry = array(
                        'actor'         => $currentUser->recordID,
                        'album'         => '',
                        'fileName'      => $fileName,
                        'url'           => UPLOAD_URL."test/".$fileName,
                        'thumbnail_url' => '',
                        'description'   => '',
                        'numberComment' => '0',
                        'statusUpload'  => 'uploading',
                        'published'     => ''
                    );
                    $this->Photo->create($entry);
                    //get recordID of each photo for pass other info
                    $infoPhotoRC    = $this->Photo->findByCondition("actor = ? AND statusUpload = 'uploading'", array($currentUser->recordID));
                    foreach ($infoPhotoRC as $infoPhoto)
                    {
                        $data['results'][]  = array(
                            'photoID'   => str_replace(':', '_', $infoPhoto->recordID),
                            'fileName'  => $infoPhoto->data->fileName,
                            'url'       => $infoPhoto->data->url,
                        );
                    }
                }

            }
            header("Content-Type: application/json; charset=UTF-8");
            $jsonData = json_encode((object)$data);
            echo $jsonData;
            if ($jsonData)
            {
                $updateEntry    = array(
                    'statusUpload'  => 'uploader',
                );
                $this->Photo->updateByCondition($updateEntry, "actor = ? AND statusUpload = 'uploading'", array($currentUser->recordID));
            }
        }
    }

    public function uploadPhoto()
    {
        if ($this->isLogin())
        {
            $output_dir = UPLOAD."test/";
            $qualityCB  = F3::get('POST.stage');
            $data       = F3::get('POST.data');
            $albumID    = F3::get('POST.albumID');
            $albumID    = ($albumID == 'none') ? $albumID : str_replace('_',':', $albumID);
            $published  = time();
            if ($qualityCB == 'checked')
            {
                if ($data)
                {
                    foreach ($data as $photo)
                    {
                        $photoID    = str_replace('_', ':',$photo['photoID']);
                        $description= $photo['description'];
                        $updateEntry = array(
                            'album'         => $albumID,
                            'description'   => $description,
                            'published'     => $published
                        );
                        $this->Photo->updateByCondition($updateEntry, "@rid = ?", array('#'.$photoID));
                        $photoRC    = $this->Photo->findOne("@rid = ?", array('#'.$photoID));
                        $filePath   = $output_dir.$photoRC->data->fileName;
                        //check size of image
                        list($width, $height) = getimagesize($filePath);
                        if ($width > 960 || $height > 960)
                            $this->resizeImage($filePath, 960, $filePath);
                    }
                }
            }else {
                if ($data)
                {
                    foreach ($data as $photo)
                    {
                        $photoID    = str_replace('_', ':',$photo['photoID']);
                        $description= $photo['description'];
                        $updateEntry = array(
                            'album'         => $albumID,
                            'description'   => $description,
                            'published'     => $published
                        );
                        $this->Photo->updateByCondition($updateEntry, "@rid = ?", array('#'.$photoID));
                        $photoRC    = $this->Photo->findOne("@rid = ?", array('#'.$photoID));
                        $filePath   = $output_dir.$photoRC->data->fileName;
                        //check size of image
                        list($width, $height) = getimagesize($filePath);
                        if ($width > 960 || $height > 960)
                            $this->resizeImage($filePath, 960, $filePath);
                        $this->compressImage($filePath,$filePath,80);
                    }
                }
            }
        }
    }

    public function removePhoto()
    {
        if ($this->isLogin())
        {
            $photoID = F3::get('POST.photoID');

            if ($photoID && !is_array($photoID))
            {
                $this->Photo->deleteByCondition("@rid = ?", array('#'.str_replace('_',':',$photoID)));
                //@todo: remove file in out put dir
            }else {
                foreach ($photoID as $id)
                {
                    $this->Photo->deleteByCondition("@rid = ?", array('#'.str_replace('_',':',$id)));
                }
            }
        }
    }

    public function createAlbum()
    {
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
            $this->Album->create($data);
        }
    }

    public function viewPhoto()
    {
        if ($this->isLogin())
        {
            $this->layout   = 'default';

            $getPhotoID     = F3::get('GET.photoID');
            $currentUser    = $this->getCurrentUser();

            if($getPhotoID != '')
            {
                $photoID    = $this->Photo->getClusterID().':'.$getPhotoID;
                $photoRC    = $this->Photo->findOne('@rid= ? ', array('#'.$photoID));
                //var_dump($photoRC);
                $albumID    = $photoRC->data->album;
                $clientAlbumID  = str_replace(':','_',$albumID);

                $listPhotos = $this->Photo->findByCondition('album = ? AND actor = ?', array($albumID, $currentUser->recordID));
                //var_dump($listPhotos);

                F3::set("numberPhoto", count($listPhotos));

                $preparedPhotosData = array();
                $preloadUrls = array();
                $comments = array();
                //var_dump($listPhotos);
                foreach ($listPhotos as $key=>$photo)
                {
                    //echo $photo->recordID."<br />";
                    $id =    substr($photo->recordID,strpos($photo->recordID,':')+1);
                    //echo $getPhotoID."<br />";
                    if($getPhotoID == $id)
                    {
                        F3::set('key',$key);
                    }
                }
                //var_dump($listPhotos);
                if ($listPhotos)
                {
                    for ($i =  0; $i < count($listPhotos); $i++)
                    {
                        array_push($preloadUrls, $listPhotos[$i]->data->url);
                        array_push($preparedPhotosData, $this->Photo->export($listPhotos[$i]));
                    }
                }
                foreach($listPhotos as $photo)
                {
                    $commentsOfPhoto[$photo->recordID]  = $this->Comment->findByCondition("post = ? ORDER BY published DESC", array($photo->recordID));
                    $infoActorUser[$photo->data->actor] = $this->User->findOne("@rid = ?", array($photo->data->actor));
                    //var_dump($commentsOfPhoto[$photo->recordID]);
                    if ($commentsOfPhoto[($photo->recordID)])
                    {
                        $pos = (count($commentsOfPhoto[($photo->recordID)]) < 4 ? count($commentsOfPhoto[($photo->recordID)]) : 4);
                        for($j = $pos - 1; $j >= 0; $j--)
                        {
                            $commentActor[$commentsOfPhoto[($photo->recordID)][$j]->data->actor] = $this->User->load($commentsOfPhoto[($photo->recordID)][$j]->data->actor);
                            //var_dump($commentActor);
                        }
                        F3::set("commentActor", $commentActor);
                    }
                }
                F3::set("photos", $listPhotos);
                F3::set("infoActorPhotoUser", $infoActorUser);
                F3::set("commentsOfPhoto", $commentsOfPhoto);
                F3::set("photosJson", json_encode($preparedPhotosData));
                F3::set("album_id", $clientAlbumID);
                F3::set("urlsJson", json_encode($preloadUrls));
                F3::set('currentUser', $currentUser);
                F3::set('otherUser', $currentUser);
                $this->render(Register::getPathModule('photo').'viewPhoto.php','modules');
            }
        }
    }

    public function addDescription()
    {
        if ($this->isLogin())
        {
            $description    = F3::get('POST.description');
            $getPhotoID     = F3::get('POST.photoID');
            $photoID        = str_replace('_', ':', $getPhotoID);

            $updateDescription = array('description'   => $description);
            $this->Photo->updateByCondition($updateDescription, "@rid = ?", array("#".$photoID));
        }
    }

    public function postComment()
    {
        if ($this->isLogin())
        {
            $currentUser    = $this->getCurrentUser();
            $photoID        = str_replace("_", ":", F3::get('POST.photoID'));
            $textComment    = F3::get('POST.comment');
            $actorName      = $this->getCurrentUserName();
            $published      = time();
            $existCommentRC = $this->Comment->findByCondition("actor = ? AND post = ?", array($currentUser->recordID, $photoID));
            if($existCommentRC)
            {
                $commentEntryCase1  = array(
                    "actor"         => $currentUser->recordID,
                    "actor_name"    => $actorName,
                    "content"       => $textComment,
                    "post"          => $photoID,
                    "status_post"   => "later",
                    "published"     => $published,
                    "tagged"        => "none"
                );
                $comment1           = $this->Comment->create($commentEntryCase1);
                $commentID          = $comment1;
            }
            else
            {
                $commentEntryCase2  = array(
                    "actor"         => $this->getCurrentUser()->recordID,
                    "actor_name"    => $actorName,
                    "content"       => $textComment,
                    "post"          => $photoID,
                    "status_post"   => "first",
                    "published"     => $published,
                    "tagged"        => "none"
                );

                $comment            = $this->Comment->create($commentEntryCase2);
                $commentID          = $comment;
            }
            /*Update number comment */
            $status_update          = $this->Photo->findOne('@rid = ?',array('#'.$photoID));
            $dataCountNumberComment = array('numberComment'     => $status_update->data->numberComment +1);
            $this->Photo->updateByCondition($dataCountNumberComment, "@rid = ?", array("#".$photoID));
            // track activity
            $userPostID             = $this->Photo->findOne("@rid = ?",array($photoID));
            $this->trackComment($currentUser, "photo".$commentID, $commentID, $photoID, $userPostID->data->actor, $published);

            F3::set('actorName', $actorName);
            F3::set('published', $published);
            F3::set('content', $textComment);
            F3::set('authorId', $this->getCurrentUser()->recordID);
            F3::set('postID', $photoID);
            F3::set('currentUser',$currentUser);
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
        if ($this->isLogin())
        {
            $profileID = $this->getCurrentUser()->recordID;
            $published = F3::get('POST.published');
            $statusID = str_replace("_", ":",  F3::get('POST.statusID'));

            if ($profileID) {
                $comments = $this->Comment->findByCondition("post = ? and published < ? LIMIT 50 ORDER BY published DESC", array($statusID, $published));
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
                $this->renderModule('morePhotoComment','photo');
            }
        }
    }
}
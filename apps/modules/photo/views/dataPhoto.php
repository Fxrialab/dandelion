<?php
$model = $this->f3->get('model');
$target = $this->f3->get('target');
$userID = $this->f3->get('userID');
if (!empty($model))
{
    //var_dump($model);
    $user = HelperController::findUser($userID);
    if ($target == 'photos')
    {
        $countPhoto = count($model);
        $arrayID = array();

        foreach ($model as $k => $photo)
        {
            $recordID = $photo->recordID;
            $actor = $photo->data->actor;
            $photoName = $photo->data->fileName;
            $numberLike = $photo->data->numberLike;
            $photoID = str_replace(':', '_', $recordID);
            $comment = HelperController::getFindComment($recordID);
            $count = HelperController::countComment($recordID);
            $like = HelperController::like($recordID);
            $f3 = require('photoItem.php');
        }
    }
    elseif ($target == 'album')
    {
        //display for untitled album
        $untitledAlbum = HelperController::findPhotosByAlbum('none');
        if (!empty($untitledAlbum))
        {
            $numberPhoto = count($untitledAlbum);
            $lastPhoto = $untitledAlbum[$numberPhoto - 1]->data->fileName;
            $f3 = require('untitledAlbumItem.php');
        }
        //display for determine an album
        foreach ($model as $k => $album)
        {
            $recordID = $album->recordID;
            $actor = $album->data->actor;
            $albumTitle = $album->data->name;
            $photos = HelperController::findPhotosByAlbum($recordID);
            if (!empty($photos))
            {
                $numberPhoto = count($photos);
                $lastPhoto = $photos[$numberPhoto - 1]->data->fileName;
            }
            else
            {
                $numberPhoto = 0;
                $lastPhoto = 'noimages.jpg';
            }
            $albumID = str_replace(':', '_', $recordID);
            $f3 = require('albumItem.php');
        }
    }
}
else
{
    ?>
    <div class="noDataDisplay">
        <span>No data to display</span>
    </div>
    <?php
}
?>
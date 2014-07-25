<?php

$photos = $this->f3->get('photos');
if ($photos)
{
    $countPhoto = count($photos);
    $arrayID = array();
    foreach ($photos as $k => $item)
    {
        $recordID = $item['recordID'];
        $photoURL = $item['fileName'];
        $numberLike = $item['numberLike'];
        $photoID = substr($recordID, strpos($recordID, ':') + 1);
        $postPhotoID = str_replace(':', '_', $recordID);
        $comment = PhotoController::getFindComment($recordID);
        $count = PhotoController::countComment($recordID);
        $like = PhotoController::like($recordID);
        include 'itemPhoto.php';
    }
}
?>
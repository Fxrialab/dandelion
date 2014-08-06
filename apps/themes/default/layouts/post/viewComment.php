<?php

if (!empty($statusID))
    $records = PostController::getFindComment($statusID);
else
    $records = F3::get('comments');

if (!empty($records))
{
    if (is_array($records))
    {
        $pos = (count($records) < 3 ? count($records) : 3);
        for ($j = count($records) - $pos; $j < count($records); $j++)
        {
            $id = str_replace(":", "_", $records[$j]->recordID);
            $recordID = $records[$j]->recordID;
            $content = $records[$j]->data->content;
            $published = $records[$j]->data->published;
            $numberLike = $records[$j]->data->numberLike;
            $profile = PostController::getUser(str_replace(":", "_", $records[$j]->data->userID));
            $like = PostController::like($records[$j]->recordID);
            if ($profile->data->profilePic != 'none')
            {
                $photo = ElementController::findPhoto($profile->data->profilePic);
                $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
            }
            else
            {
                $profilePic = UPLOAD_URL . 'avatar/170px/avatar.png';
            }
            $actorComment = ucfirst($profile->data->firstName) . " " . ucfirst($profile->data->lastName);
            $f3 = require('commentItem.php');
        }
    }
    elseif (is_object($records))
    {
        $profile = PostController::getUser(str_replace(":", "_", $records->data->userID));
        $like = PostController::like($records->recordID);
        $actorComment = ucfirst($profile->data->firstName) . " " . ucfirst($profile->data->lastName);
        if ($profile->data->profilePic != 'none')
        {
            $photo = ElementController::findPhoto($profile->data->profilePic);
            $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
        }
        else
        {
            //check men or women later
            $profilePic = UPLOAD_URL . "avatar/170px/avatarMenDefault.png";
        }
        $id = str_replace(":", "_", $records->recordID);
        $recordID = $records->recordID;
        $content = $records->data->content;
        $published = $records->data->published;
        $numberLike = $records->data->numberLike;
        $f3 = require('commentItem.php');
    }
}
?>
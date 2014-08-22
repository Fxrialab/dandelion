<?php

$records = F3::get('comments');
if (!empty($records))
{
    foreach ($records as $value)
    {
        $id = str_replace(":", "_", $value->recordID);
        $recordID = $value->recordID;
        $content = $value->data->content;
        $published = $value->data->published;
        $numberLike = $value->data->numberLike;
        $profile = PostController::getUser(str_replace(":", "_", $value->data->userID));
        $like = PostController::like($value->recordID);
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
        $f3 = require('commentItem.php');
    }
}
?>
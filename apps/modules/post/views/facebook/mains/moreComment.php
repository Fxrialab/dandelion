<?php

$records = $this->f3->get('comments');
if (!empty($records))
{
    foreach ($records as $value)
    {
        $id = str_replace(":", "_", $value->recordID);
        $recordID = $value->recordID;
        $content = $value->data->content;
        $published = $value->data->published;
        $numberLike = $value->data->numberLike;
        $profile = HelperController::findUser(str_replace(":", "_", $value->data->userID));
        $like = HelperController::like($value->recordID);
        $actorComment = ucfirst($profile->data->firstName) . " " . ucfirst($profile->data->lastName);
        if ($profile->data->profilePic != 'none')
        {
            $photo = HelperController::findPhoto($profile->data->profilePic);
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
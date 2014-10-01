<?php

//var_dump(F3::get('SESSION.userID'));
if (!empty($objectID))
    $records = HelperController::getFindComment($objectID);
else
    $records = $this->f3->get('comments');

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
            $profile = HelperController::findUser($records[$j]->data->userID);
            $like = HelperController::like($records[$j]->recordID);
            if ($profile->data->profilePic != 'none')
            {
                $photo = HelperController::findPhoto($profile->data->profilePic);
                $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
            }
            else
            {
                $gender = HelperController::findGender($profile->recordID);
                if ($gender == 'male')
                    $profilePic = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                else
                    $profilePic = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
            }
            $actorComment = ucfirst($profile->data->firstName) . " " . ucfirst($profile->data->lastName);
            $f3 = require('commentItem.php');
        }
    }
    elseif (is_object($records))
    {
        $profile = HelperController::findUser($records->data->userID);
        $like = HelperController::like($records->recordID);
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
        $id = str_replace(":", "_", $records->recordID);
        $recordID = $records->recordID;
        $content = $records->data->content;
        $published = $records->data->published;
        $numberLike = $records->data->numberLike;
        $f3 = require('commentItem.php');
    }
}
?>
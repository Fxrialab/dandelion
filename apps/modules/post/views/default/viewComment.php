<?php
if (!empty($statusID))
    $records = PostController::getFindComment($statusID);
else
    $records = $this->f3->get('comments');
//var_dump($records);
if (!empty($records))
{
    if (is_array($records))
    {
        $pos = (count($records) < 3 ? count($records) : 3);
        for ($j = count($records)- $pos; $j < count($records); $j++)
        {
            $content    = $records[$j]->data->content;
            $published  = $records[$j]->data->published;
            $profile    = PostController::getUser(str_replace(":", "_", $records[$j]->data->actor));
            if ($profile->data->profilePic != 'none')
            {
                $photo = ElementController::findPhoto($profile->data->profilePic);
                $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
            }else {
                $gender = ElementController::findGender($profile->recordID);
                if ($gender == 'male')
                    $profilePic = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                else
                    $profilePic = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
            }
            $actorComment = ucfirst($profile->data->firstName)." ".ucfirst($profile->data->lastName);
            ?>
            <div class="eachCommentItem verGapBox column-group">
                <div class="large-10 uiActorCommentPicCol">
                    <a href="/content/post?user=<?php echo $profile->data->username; ?>"><img src="<?php echo $profilePic; ?>"></a>
                </div>
                <div class="large-85 uiCommentContent">
                    <p>
                        <a class="timeLineCommentLink" href="/content/post?user=<?php echo $profile->data->username; ?>"><?php echo $actorComment; ?></a>
                        <span class="textComment"><?php echo $content; ?></span>
                    </p>
                    <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
                </div>
            </div>
        <?php
        }
    }elseif (is_object($records)) {
        $profile    = PostController::getUser(str_replace(":", "_", $records->data->actor));
        $actorComment = ucfirst($profile->data->firstName)." ".ucfirst($profile->data->lastName);
        if ($profile->data->profilePic != 'none')
        {
            $photo = ElementController::findPhoto($profile->data->profilePic);
            $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
        }else {
            //check men or women later
            $profilePic = UPLOAD_URL . "avatar/170px/avatarMenDefault.png";
        }
        $content    = $records->data->content;
        $published  = $records->data->published;
        ?>
        <div class="eachCommentItem verGapBox column-group">
            <div class="large-10 uiActorCommentPicCol">
                <a href="/content/post?user=<?php echo $profile->data->username; ?>"><img src="<?php echo $profilePic; ?>"></a>
            </div>
            <div class="large-85 uiCommentContent">
                <p>
                    <a class="timeLineCommentLink" href="/content/post?user=<?php echo $profile->data->username; ?>"><?php echo $actorComment; ?></a>
                    <span class="textComment"><?php echo $content; ?></span>
                </p>
                <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
            </div>
        </div>
        <?php
    }
}
?>
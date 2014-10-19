<?php
if($data['type'] == 'like')
{
    $user = HelperController::findUser(str_replace('_',':', $data['dispatch']));
    $likeBy = HelperController::getFullNameUser(str_replace('_',':', $data['dispatch']));
    ?>
    <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $data['target']; ?>">
        <span><i class="statusCounterIcon-like"></i>
            <a href="/user/<?php echo $user->data->username; ?>">
                <?php echo $likeBy; ?>
            </a> like this.
        </span>
    </div>
<?php
}elseif ($data['type'] == 'comment'){
    $user = HelperController::findUser(str_replace('_',':', $data['dispatch']));
    $commentBy = HelperController::getFullNameUser(str_replace('_',':', $data['dispatch']));
    if ($user->data->profilePic != 'none')
    {
        $photo = HelperController::findPhoto($user->data->profilePic);
        $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
    }else {
        $gender = HelperController::findGender($user->recordID);
        if ($gender == 'male')
            $profilePic = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
        else
            $profilePic = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
    }
?>
    <div class="eachCommentItem verGapBox column-group">
        <div class="large-10 uiActorCommentPicCol">
            <a href="/user/<?php echo $user->data->username; ?>"><img src="<?php echo $profilePic; ?>"></a>
        </div>
        <div class="large-85 uiCommentContent">
            <p>
                <a class="timeLineCommentLink" href="/user/<?php echo $user->data->username; ?>"><?php echo $commentBy; ?></a>
                <span class="textComment"><?php echo $data['content']; ?></span>
            </p>
            <span><a class="linkColor-999999 swTimeComment" name="<?php echo $data['published']; ?>"></a></span>
        </div>
    </div>
<?php
}
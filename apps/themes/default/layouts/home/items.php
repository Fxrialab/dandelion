<?php
if($data['type'] == 'like')
{
    $user = ElementController::findUser(str_replace('_',':', $data['dispatch']));
    $likeBy = ElementController::getFullNameUser(str_replace('_',':', $data['dispatch']));
    ?>
    <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $data['target']; ?>">
        <span><i class="statusCounterIcon-like"></i>
            <a href="/content/post?user=<?php echo $user->data->username; ?>">
                <?php echo $likeBy; ?>
            </a> like this.
        </span>
    </div>
<?php
}elseif ($data['type'] == 'comment'){
    $user = ElementController::findUser(str_replace('_',':', $data['dispatch']));
    $commentBy = ElementController::getFullNameUser(str_replace('_',':', $data['dispatch']));
    if ($user->data->profilePic != 'none')
    {
        $photo = ElementController::findPhoto($user->data->profilePic);
        $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
    }else {
        $gender = ElementController::findGender($user->recordID);
        if ($gender == 'male')
            $profilePic = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
        else
            $profilePic = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
    }
?>
    <div class="eachCommentItem verGapBox column-group">
        <div class="large-10 uiActorCommentPicCol">
            <a href="/content/post?user=<?php echo $user->data->username; ?>"><img src="<?php echo $profilePic; ?>"></a>
        </div>
        <div class="large-85 uiCommentContent">
            <p>
                <a class="timeLineCommentLink" href="/content/post?user=<?php echo $user->data->username; ?>"><?php echo $commentBy; ?></a>
                <span class="textComment"><?php echo $data['content']; ?></span>
            </p>
            <span><a class="linkColor-999999 swTimeComment" name="<?php echo $data['published']; ?>"></a></span>
        </div>
    </div>
<?php
}
<?php
$comment = F3::get('comment');
if (!empty($comment))
{
    $id = str_replace('_', ':', $comment->recordID);
    $profile = Controller::getID('user', $comment->data->userID);
    $like = Controller::getArray('like', array('actor' => F3::get('SESSION.userID'), 'objID' => $comment->recordID));
    if (!empty($like))
        $liked = TRUE;
    else
        $liked = FALSE;
    ?>
    <div class="eachCommentItem verGapBox column-group">
        <div class="large-10 uiActorCommentPicCol">
            <a href="/content/post?user=<?php echo $profile->data->username; ?>"><img src="<?php echo UPLOAD_URL . $profile->data->profilePic; ?>"></a>
        </div>
        <div class="large-85 uiCommentContent">
            <p>
                <a class="timeLineCommentLink" href="/content/post?user=<?php echo $profile->data->username; ?>"><?php $profile->data->fullName ?></a>
                <span class="textComment"><?php echo $comment->data->content; ?></span>
            </p>
            <a class="swTimeComment" name="<?php echo $comment->data->published; ?>"></a>
            <span class="like_<?php echo $id ?>">
                <?php
                if ($like = TRUE)
                {
                    ?>
                    <a class="likeAction" id="<?php echo $id ?>" rel="comment">Like</a>
                    <?php
                }
                else
                {
                    ?>
                    <a class="unlikeAction" id="<?php echo $id ?>" rel="comment">UnLike</a>
                <?php } ?>
            </span>
            <span class="numLike-<?php echo $id ?>"><?php echo $comment->data->numberLike ?></span>
        </div>
    </div>
    <?php
}?>
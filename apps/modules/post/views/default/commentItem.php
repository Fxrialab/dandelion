<div class="eachCommentItem verGapBox column-group">
    <div class="large-10 uiActorCommentPicCol">
        <a href="/content/post?user=<?php echo $profile->data->username; ?>"><img src="<?php echo $profilePic; ?>"></a>
    </div>
    <div class="large-85 uiCommentContent">
        <p>
            <a class="timeLineCommentLink" href="/content/post?user=<?php echo $profile->data->username; ?>"><?php echo $actorComment; ?></a>
            <span class="textComment"><?php echo $content; ?></span>
        </p>
        <a class="swTimeComment" name="<?php echo $published; ?>"></a>
        <span class="like_<?php echo $id ?>">
            <?php
            if ($like == 0)
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
        <span class="numLike-<?php echo $id ?>"><?php echo $numberLike ?></span>
    </div>
</div>
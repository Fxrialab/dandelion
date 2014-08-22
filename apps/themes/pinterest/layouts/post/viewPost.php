<?php
$status = F3::get('status');
$image = F3::get('image');
$like = F3::get('like');
$user = F3::get('user');
$comment = F3::get('comment');
$id = $status->recordID;
?>
<div class="post post_<?php echo str_replace(':', '_', $id) ?>">
    <div class="thumb-holder">
        <div class="imgAction">
            <a href="javascript:void(0)" class="ink-button red pin link-button" relPin="<?php echo str_replace(':', '_', $id) ?>" >Pin</a>
            <span class="like-<?php echo str_replace(':', '_', $id) ?>">
                <?php
                if ($like == TRUE)
                {
                    ?>
                    <a class="unlikeAction ink-button link-button" id="<?php echo str_replace(':', '_', $id) ?>" rel="status" title="Unlike">Unlike</a>
                    <?php
                }
                else
                {
                    ?>
                    <a class="likeAction ink-button link-button" id="<?php echo str_replace(':', '_', $id) ?>" rel="status" title="Like">Like</a>
                <?php } ?>
            </span>
        </div>
        <a class="postImage" href="javascript:void(0)" rel="<?php echo str_replace(':', '_', $id) ?>"> 
            <?php
            if (!empty($image) && !empty($image[0]))
            {
                ?>
                <img src="<?php echo UPLOAD_URL . $image[0]['fileName'] ?>"  style="width:220px;">
                <?php
            }
            ?>

        </a> 
        <div class="thumbtitle"><?php echo $status->data->content ?></div>

    </div>
    <div class="post-action">
        <a href="user?user=<?php echo str_replace(':', '_', $id) ?>&post=prin" id="numC-<?php echo str_replace(':', '_', $id) ?>"><?php echo $status->data->numberComment ?></a>
        <a href="likes?id=<?php echo str_replace(':', '_', $id) ?>" id="numLike-<?php echo str_replace(':', '_', $id) ?>"><?php echo $status->data->numberLike ?></a>
    </div>
    <div class="post-meta">
        <div class="post-meta-avatar"><a href="user?user=<?php echo $user->data->username ?>"><img alt="" src="<?php echo UPLOAD_URL . 'avatar/170px/' . $user->data->profilePic ?>" class="avatar avatar-30 photo" height="30" width="30"></a></div>
        <div class="post-meta-comment">
            <span class="post-meta-author">       
                <a href="user?user=<?php echo $user->data->username ?>"><?php echo $user->data->fullName ?></a>
            </span> 
        </div>
    </div>
    <div class="post-comment_<?php echo str_replace(':', '_', $id) ?>">
        <?php
        if (!empty($comment))
        {
            foreach ($comment as $value)
                ViewHtml::render('post/commentItem', array('comment' => $value));
        }
        ?>
    </div>
    <?php
    ViewHtml::render('post/formComment', array('id' => str_replace(':', '_', $id)));
    ?>
</div>
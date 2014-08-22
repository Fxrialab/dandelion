<?php
$comment = F3::get('comment');
$profile = Controller::getID('user', $comment->data->userID);
?>
<div class="post-meta">
    <div class="post-meta-avatar"><a href="/content/post?user=<?php echo $profile->data->username; ?>">
            <img alt="" src="<?php echo UPLOAD_URL . 'avatar/170px/' . $profile->data->profilePic; ?>" class="avatar avatar-30 photo" height="30" width="30"></a></div>
    <div class="post-meta-comment">
        <span class="post-meta-author">       
            <a href="/content/post?user=<?php echo $profile->data->username; ?>"><?php echo $profile->data->fullName; ?></a>
        </span> 
        <span class="masonry-meta-content">
            <?php echo $comment->data->content; ?>
        </span>
    </div>
</div>
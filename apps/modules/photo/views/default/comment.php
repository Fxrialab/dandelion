<?php
$content    = F3::get('content');
$published  = F3::get('published');
$authorName = F3::get('actorName');
$authorRID  = F3::get('authorId');
$authorID   = substr( $authorRID, strpos($authorRID, ":") + 1);
$photoID    = F3::get('postID');
$currentUser= F3::get('currentUser');
?>
<div class="swCommentPostedPhoto <?php echo str_replace(':', '_', $photoID) ?>" id="commentImagePost">
    <div class="swImg">
        <img class="swCommentImg" src="<?php echo $currentUser->data->profilePic;  ?>" />
    </div>
    <div class="commentContentPhoto">
        <a href="/profile?username=<?php echo $currentUser->data->username?>"><?php echo $authorName;?></a>
        <label class="swPostedCommment"><?php echo $content; ?></label>
        <label class="swTimeComment" title="<?php echo $published; ?>"></label>
    </div>
</div>
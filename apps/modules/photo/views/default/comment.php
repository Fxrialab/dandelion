<?php
$content    = F3::get('content');
$published  = F3::get('published');
$authorName = F3::get('authorName');
$authorRID  = F3::get('authorId');
$authorID   = substr( $authorRID, strpos($authorRID, ":") + 1);
$photoID    = F3::get('postID');
$currentUser= F3::get('currentUser');
?>
<div class="swCommentPosted <?php echo str_replace(':', '_', $photoID) ?>" id="commentImagePost">
    <div class="swImg">
        <img class="swCommentImg" src="<?php echo $currentUser->data->profilePic;  ?>" />
    </div>
    <div>
        <a href="/profile?id=<?php echo $authorID?>"><?php echo $authorName;?></a>
        <label class="swPostedCommment"><?php echo $content; ?></label>
        <label class="swTimeComment" title="<?php echo $published; ?>"></label>
    </div>
</div>
<?php
$content    = $this->f3->get('content');
$published  = $this->f3->get('published');
$authorName = $this->f3->get('actorName');
$currentUser= $this->f3->get('currentUser');
$username   = $currentUser->data->username;
?>
<div class="eachCommentItem verGapBox column-group">
    <div class="large-20 uiActorCommentPicCol">
        <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
    </div>
    <div class="large-80 uiCommentContent">
        <p>
            <a class="timeLineCommentLink" href="/content/myPost?username=<?php echo $username; ?>"><?php echo $authorName; ?></a>
            <span class="textComment"><?php echo $content; ?></span>
        </p>
        <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
    </div>
</div>
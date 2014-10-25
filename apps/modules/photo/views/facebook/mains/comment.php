<?php
$comment = $this->f3->get('comment');
$user = $this->f3->get('user');
?>
<div class="eachCommentItem verGapBox column-group">
    <div class="large-10 uiActorCommentPicCol">
        <a href="/content/post?user=">  <img src="<?php echo IMAGES ?>/avatarMenDefault.png"></a>
    </div>
    <div class="large-85 uiCommentContent">
        <p>
            <a class="timeLineCommentLink" href="/content/post?user="><?php echo $user->data->fullName ?></a>
            <span class="textComment"> <?php echo $comment->data->content ?></span>
        </p>
        <a class="swTimeComment" name="<?php echo $comment->data->published; ?>"></a>
    </div>
</div>
<?php
$comment = $this->f3->get('comment');
$user = $this->f3->get('user');
$like = $this->f3->get('like');
$commentID = str_replace(':', '_', $comment->recordID);
?>
<li class="eachCommentItem verGapBox column-group" style="margin:1px 0; padding: 5px 10px">
    <div class="large-15 uiActorCommentPicCol">
        <a href="/user/<?php echo $user->data->username ?>">  <img style="min-width: 40px; height:40px" src="<?php echo IMAGES ?>/avatarMenDefault.png"></a>
    </div>
    <div class="large-85 uiCommentContent uiComment_<?php echo $commentID ?>">
        <p>
            <a class="timeLineCommentLink" href="/user/<?php echo $user->data->username ?>"><?php echo $user->data->fullName ?></a>
            <span class="textComment"> <?php echo $comment->data->content ?></span>
        </p>
        <a class="swTimeComment" name="<?php echo $comment->data->published; ?>"></a>
        <a class="uiLike like_<?php echo $commentID ?>" data-like="comment;<?php echo $this->f3->get('SESSION.userID') . ';' . $comment->recordID ?>" data-rel="<?php echo $like ? "unlike" : "like" ?>"><?php echo $like ? "Unlike" : "Like" ?></a>
        <a href="#" class="l2_<?php echo $commentID ?>"> <?php echo $comment->data->numberLike ?></a>
    </div>
</li>
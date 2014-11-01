<div class="eachCommentItem verGapBox column-group">
    <div class="large-10 uiActorCommentPicCol">
        <a href="/user/<?php echo $profile->data->username; ?>"><img src="<?php echo $avatar; ?>"></a>
    </div>
    <div class="large-85 uiCommentContent">
        <p>
            <a class="timeLineCommentLink" href="/user/<?php echo $profile->data->username; ?>"><?php echo $profile->data->fullName; ?></a>
            <span class="textComment"><?php echo $content; ?></span>
        </p>
        <a class="swTimeComment" name="<?php echo $published; ?>"></a>
        <a class="uiLike like_<?php echo $id ?>" data-like="comment;<?php echo $this->f3->get('SESSION.userID') . ';' . $recordID ?>" data-rel="<?php echo $like ? "unlike" : "like" ?>"><?php echo $like ? "Unlike" : "Like" ?></a>
        <a href="#" class="l2_<?php echo $id ?>"> <?php echo $numberLike ?></a>
    </div>
    <div class="large-5">
        <?php
        if ($userID == $profile->recordID)
        {
            ?>
            <a data-dropdown="#dropdown_oc<?php echo $id; ?>"><i class="icon30-options"></i></a>
            <div id="dropdown_oc<?php echo $id; ?>" class="dropdown dropdown-tip dropdown-anchor-right dropdown-right">
                <ul class="dropdown-menu">

                    <li><a class="test" href="#">Edit..</a></li>
                    <li><a class="deleteAction" id="<?php echo $id; ?>">Delete...</a></li>

                </ul>
            </div>
            <?php
        }
        else
        {
            ?>
            <a class="hideComment" href="#"><i class="icon30-close"></i></a></li>
        <?php } ?>

    </div>
</div>
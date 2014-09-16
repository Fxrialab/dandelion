<div class="large-33">
    <div class="photoItems">
        <a class="detailPhoto" url="/content/photo/detail?id=<?php echo $photoID ?>&p=<?php echo $k ?>">
            <img src="<?php echo UPLOAD_URL.'images/' . $photoName; ?>" height="200">
        </a>

        <div class="num"><div class="numLike-<?php echo $photoID ?>"> <?php echo $numberLike ?> </div>
            <div class="comment_<?php echo $photoID ?>"> <?php echo $count ?> </div></div>
        <div class="action" id="<?php echo $photoID; ?>">
            <span class="like_<?php echo $photoID ?>">
                <?php
                if ($like == 0)
                {
                    ?>
                    <a class="likeAction" id="<?php echo $photoID; ?>" rel="photo">Like</a>
                    <?php
                }
                else
                {
                    ?>
                    <a class="unlikeAction" id="<?php echo $photoID; ?>" rel="photo">UnLike</a>
                <?php } ?>
            </span>
            <a data-dropdown="#dropdown-c<?php echo $photoID ?>" rel="<?php echo $photoID ?>" class="open commentPhoto" >Comment</a>
            <?php
            if (($k + 1) % 3 == 0)
                $right = 'dropdown-comment-right';
            else
                $right = '';
            ?>
            <div id="dropdown-c<?php echo $photoID ?>" class="dropdown dropdown-tip dropdown-comment <?php echo $right ?>">
                <ul class="viewComment_<?php echo $photoID ?>  viewComment dropdown-menu" style="width: 300px">
                    <div class="mCustomScrollbar" style="max-height: 170px;">
                        <?php
                        if (!empty($comment))
                        {
                            foreach ($comment as $k => $value)
                            {
                                $user = PhotoController::getUser($value->data->userID);
                                ?>
                                <li class="itemC_<?php echo str_replace(':', '_', $value->recordID) ?>">
                                    <div class="avatar">
                                        <img src="<?php echo IMAGES ?>/avatarMenDefault.png">
                                    </div>
                                    <div class="content">
                                        <a href="#" class="fullName"><?php echo $user->data->fullName ?></a>
                                        <?php echo $value->data->content ?>
                                        <p><a class="swTimeComment" name="<?php echo $value->data->published; ?>"></a></p>
                                    </div>

                                </li>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <li>
                        <div style="padding:5px 0; margin: 0">
                            <form id="form_<?php echo $photoID; ?>">
                                <div  style="width:30px; height: 30px; float: left;  margin-right: 5px">
                                    <img src="<?php echo IMAGES ?>/avatarMenDefault.png">
                                </div>
                                <input name="photoID" type="hidden" value="<?php echo $photoID; ?>" />
                                <textarea style="width:250px; height: 30px" name="comment" class="submitCommentPhoto" id="photoComment-<?php echo $photoID; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
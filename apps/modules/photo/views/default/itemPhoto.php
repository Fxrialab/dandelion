<div class="large-33">
    <div class="photoItems">
        <a class="viewThisPhoto" id="<?php echo $photoID; ?>">
            <img src="<?php echo UPLOAD_URL . $photoURL; ?>">
        </a>

        <div class="num"><div class="like_<?php echo $postPhotoID ?>"> 12 </div>  <div class="comment_<?php echo $postPhotoID ?>"> <?php echo $count ?> </div></div>
        <div class="action" id="<?php echo $photoID; ?>">
            <a href="javascript:void(0)" class="likePhoto">Like</a>
            <a href="javascript:void(0)" rel="<?php echo $postPhotoID ?>" class="open commentPhoto" >Comment</a>
            <?php
            if ($count >= 4)
                $height = 4 * 40 + 50;
            else
                $height = $count * 40 + 50;
            ?>
            <div style=" height: <?php echo $height ?>px; bottom: -<?php echo $height ?>px" class="box" id="box_<?php echo $postPhotoID ?>">
                <div class="arrow_box">
                    <ul class="viewComment_<?php echo $postPhotoID ?> mCustomScrollbar viewComment">
                        <?php
                        if (!empty($comment))
                        {
                            foreach ($comment as $k => $value)
                            {
                                $user = PhotoController::getUser($value->data->actor);
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

                    </ul>
                    <div style="padding:0 5px 5px; margin: 0">
                        <form id="form_<?php echo $postPhotoID; ?>">
                            <div  style="width:30px; height: 30px; float: left;  margin-right: 5px">
                                <img src="<?php echo IMAGES ?>/avatarMenDefault.png">
                            </div>
                            <input name="photoID" type="hidden" value="<?php echo $recordID; ?>" />
                            <textarea style="width:255px; height: 30px" name="comment" class="submitCommentPhoto" id="photoComment-<?php echo $postPhotoID; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
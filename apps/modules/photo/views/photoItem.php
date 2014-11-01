<?php
$photoID = str_replace(':', '_', $photo->recordID);
?>
<div class="large-33">
    <div class="photoItems">
        <a class="popupPhoto" href="/content/photo/popupPhoto?pID=<?php echo $actor->recordID ?>_0_<?php echo $photo->recordID ?>_<?php echo $k ?>">
            <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $photo->data->fileName; ?>)"></i>

        </a>
    </div>
    <div class="action">
        <nav class="ink-navigation">
            <ul class="menu horizontal">
                <li>
                    <span class="like_<?php echo $photoID ?>">
                        <?php
                        if (!empty($like))
                        {
                            ?>
                            <a class="unlikeAction" id="<?php echo $photoID; ?>" rel="photo">UnLike</a>

                            <?php
                        }
                        else
                        {
                            ?>
                            <a class="likeAction" id="<?php echo $photoID; ?>" rel="photo">Like</a>
                        <?php } ?>
                    </span>
                </li>
                <li>
                    <a data-dropdown="#dropdown_c<?php echo $photoID ?>" rel="<?php echo $photoID ?>" class="open" >Comment</a>
                    <?php
                    if (($k + 1) % 3 == 0)
                        $right = 'dropdown-comment-right';
                    else
                        $right = '';
                    ?>
                    <div id="dropdown_c<?php echo $photoID ?>" class="dropdown dropdown-tip <?php echo $right ?>" style="background-color: #eaeaea; border-radius: 3px; border-bottom: none; border:1px solid rgba(0, 0, 0, .2)">
                        <div class="mCustomScrollbar" style="max-height: 170px;">
                            <ul class="commentContentWrapper viewComment_<?php echo $photoID ?>  viewComment dropdown-menu" style="width: 300px; border: none; padding: 0 !important; float: left">

                                <?php
                                if (!empty($value['comment']))
                                {
                                    foreach ($value['comment'] as $v)
                                    {
                                        $comment = $v['comment'];
                                        $user = $v['user'];
                                        $likeComment = $v['like'];
                                        $f3 = require('viewComment.php');
                                    }
                                }
                                ?>
                            </ul>

                        </div>
                        <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $photoID ?>" style="border-radius: 0 0 4px 3px; border-top: none; padding: 5px 10px;">
                            <div class="large-15 uiActorCommentPicCol">
                                <a href="/user/"><img src="<?php echo IMAGES . '/' . $this->f3->get('SESSION.avatar') ?>"></a>
                            </div>
                            <div class="large-85 uiTextCommentArea">
                                <?php
                                $uni = uniqid();
                                $f3 = require('formComment.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="right"><span class="comment_<?php echo $photoID ?>"> <?php echo count($value['comment']) ?> </span></li>
                <li class="right"><span class="numLike-<?php echo $photoID ?>"> <?php echo $photo->data->numberLike ?> </span></li>
            </ul>
        </nav>
    </div>
</div>
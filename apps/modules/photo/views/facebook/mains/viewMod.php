<?php
$rpStatusID = str_replace(":", "_", $objectID);
$album = HelperController::findAlbum($objectID);
?>
<div class="uiBoxPostItem postItem-<?php echo $rpStatusID; ?>">
    <div class="uiBoxPostContainer column-group">
        <div class="large-10 uiActorPicCol">
            <a href="/user/<?php echo $username ?>"><img src="<?php echo $avatar ?>"></a>
        </div>
        <div class="large-85">
            <div class="postContent">
                <a href="/user/<?php echo $username ?>" class="timeLineLink"><?php echo $actorName; ?> </a>
                <span>added <?php echo count($status); ?> photos to <a href="/content/photo?user=<?php echo $username ?>&album=<?php echo $rpStatusID; ?>"><?php echo $album->data->name; ?></a> album</span>
                <div class="column-group">
                    <div class="textPostContainer">
                        <span class="textPost"><?php echo $album->data->description; ?></span>
                    </div>

                    <?php
                    if (!empty($status))
                    {
                        foreach ($status as $k=>$photo)
                        {
                            if (count($status) == 1)
                                echo '<div class="large-100"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $photo->recordID) . '&id=' . str_replace(":", "_", $photo->recordID) . '&p=' . $k . '"><img style="margin: 5px 0" src=' . UPLOAD_URL .'images/'. $photo->data->fileName . '></a></div>';
                            elseif (count($status) == 3)
                                echo '<div class="large-30"><div class="imgPost"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $photo->recordID) . '&id=' . str_replace(":", "_", $photo->recordID) . '&p=' . $k . '"><img style="margin: 5px 0" src=' . UPLOAD_URL .'images/'. $photo->data->fileName . '></a></div></div>';
                            else
                                echo '<div class="large-50"><div class="imgPost"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $photo->recordID) . '&id=' . str_replace(":", "_", $photo->recordID) . '&p=' . $k . '"><img style="margin: 5px 0" src=' . UPLOAD_URL .'images/'. $photo->data->fileName . '></a></div></div>';
                        }
                    }
                    ?>
                 </div>
                <div class="articleSelectOption">
                    <nav class="ink-navigation">
                        <ul class="menu horizontal">
                            <!--Like Segments-->
                            <li class="like-<?php echo $rpStatusID ?>">
                                <a class="likeAction" id="<?php echo $rpStatusID ?>" rel="status" title="Like">Like</a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <!--Comment Segments-->
                            <li>
                                <a href="#" class="commentBtn" id="stream-<?php echo $rpStatusID ?>" title="Comment to post">Comment</a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <!--Share Segments-->
                            <li><a class="shareStatus" id="<?php echo $rpStatusID ?>" title="Share">Share</a></li>
                            <li class="gapArticleActions">.</li>

                            <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $album->data->published; ?>"></a></li>
                            <!----article post counter---->
                            <li class="rightFix">
                                <span>
                                    <a href="#" class="likeCounter gapArticleActions" title="Like"><i class="statusCounterIcon-like"></i><span id="numLike-<?php echo $rpStatusID ?>">0</span></a>
                                    <a href="#" class="commentCounter gapArticleActions" title="Comment"><i class="statusCounterIcon-comment"></i><span id="numC-<?php echo $rpStatusID ?>">0</span></a>
                                    <a href="#" class="shareCounter gapArticleActions" title="Share"><i class="statusCounterIcon-share"></i><span id="numS-<?php echo $rpStatusID ?>">0</span></a>

                                </span>
                            </li>
                        </ul>
                    </nav>
                    <div class="postItem-<?php echo $rpStatusID ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $rpStatusID ?> postItem">
                        <div class="commentContentWrapper moreComment-<?php echo $rpStatusID ?>">
                        </div>
                        <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $rpStatusID ?>">
                            <div class="large-10 uiActorCommentPicCol">
                                <a href="/user/<?php echo $username ?>"><img src="<?php echo $avatar ?>"></a>
                            </div>
                            <div class="large-90 uiTextCommentArea">
                                <form class="ink-form" id="fmComment-<?php echo $rpStatusID ?>">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="control">
                                                <input name="postID" type="hidden" value="<?php echo $rpStatusID ?>">
                                                <textarea name="comment" class="taPostComment submitComment" id="textComment-<?php echo $rpStatusID ?>" spellcheck="false" placeholder="Write a comment..." style="overflow: hidden; word-wrap: break-word; resize: none; height: 38px;"></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-5">
            <a data-dropdown="#dropdown-<?php echo $rpStatusID ?>"><i class="icon30-options"></i></a>
            <div id="dropdown-<?php echo $rpStatusID ?>" class="dropdown dropdown-tip dropdown-anchor-right dropdown-right-option">
                <ul class="dropdown-menu">
                    <li><a class="test" href="#">Report this post</a></li>
                    <li><a class="deleteAction" id="<?php echo $rpStatusID ?>">Delete this post</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
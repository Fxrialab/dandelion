<?php
$currentUserID = $currentUser->recordID;
$status = $mod["actions"];
$statusID = $mod['statusID'];
$rpStatusID = str_replace(":", "_", $statusID);
$username = PostController::getUser(str_replace(":", "_", $mod['actor']));
?>
<div class="uiBoxPostItem">
    <div class="uiBoxPostContainer column-group">
        <div class="large-10 uiActorPicCol">
            <a href="/content/myPost?username=<?php echo $username->data->username ?>"><img src="<?php echo $mod['otherUser_profilePic']; ?>"></a>
        </div>
        <div class="large-85 uiPostContent">
            <div class="articleActorName fixMarginBottom-5">
                <a href="/content/myPost?username=<?php echo $username->data->username ?>" class="timeLineLink"><?php echo $status->data->actorName; ?></a>
            </div>
            <div class="articleContentWrapper">
                <div class="textPostContainer fixMarginBottom-5">
                    <span class="textPost"><?php echo $status->data->content; ?></span>
                </div>

            </div>
            <div class="articleSelectOption">
                <div class="articleActions">
                    <nav class="ink-navigation">
                        <ul class="menu horizontal">
                            <!--Like Segments-->
                            <li>
                                <a class="likeSegments" id="likeLinkID-<?php echo $rpStatusID; ?>" name="likeStatus-<?php echo $mod['likeStatus'][$statusID]; ?>" title="Like post">Like</a>
                                <form class="likeHidden" id="likeHiddenID-<?php echo $rpStatusID; ?>">
                                    <input type="hidden" name="id" value="<?php echo substr($mod["actor"], strpos($mod["actor"], ':') + 1); ?>">
                                    <input type="hidden" name="statusID" value="<?php echo $rpStatusID; ?>">
                                    <input type="hidden" name="numLike" id="numLikeValue-<?php echo $rpStatusID; ?>" value="<?php echo $status->data->numberLike ?>">
                                </form>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <!--Comment Segments-->
                            <li>
                                <a href="#" class="commentBtn" id="stream-<?php echo $rpStatusID; ?>" title="Comment to post">Comment</a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <?php
                            if ($status->data->contentShare == 'none') {
                                ?>
                                <!--Share Segments-->
                                <li ><a class="shareStatus" onclick="ShareStatus('<?php echo str_replace(":", "_", $statusID); ?>')" title="Share">Share</a></li>
                                <li class="gapArticleActions">.</li>
                                <?php
                            } else {
                                ?>
                                <!--Share Segments-->
                                <li ><a class="shareStatus" onclick="ShareStatus('<?php echo str_replace(":", "_", $status->data->mainStatus); ?>')" title="Share">Share</a></li>
                                <li class="gapArticleActions">.</li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($status->data->actor != $currentUserID) {
                                ?>
                                <!--Follow post Segments-->
                                <li>
                                    <a class="followPostSegments" id="followID-<?php echo $rpStatusID; ?>" name="getStatus-<?php echo $statusFollow[$statusID]; ?>" title="Follow"></a>
                                    <form class="followBtn" id="fmFollow-<?php echo $rpStatusID; ?>">
                                        <input type="hidden" name="id" value="<?php echo substr($actor, strpos($actor, ':') + 1); ?>">
                                        <input type="hidden" name="statusID" value="<?php echo $rpStatusID; ?>">
                                    </form>
                                </li>
                                <li class="gapArticleActions">.</li>
                                <?php
                            }
                            ?>
                            <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $status->data->published; ?>"></a></li>
                            <!----article post counter---->
                            <li class="rightFix">
                                <span>
                                    <a href="#" class="likeCounter gapArticleActions" title="Like"><i class="statusCounterIcon-like"></i><span id="numLike-<?php echo $rpStatusID; ?>"><?php echo $status->data->numberLike ?></span></a>
                                    <a href="#" class="commentCounter gapArticleActions" title="Comment"><i class="statusCounterIcon-comment"></i><span id="numC-<?php echo $rpStatusID; ?>"><?php echo $status->data->numberComment ?></span></a>
                                    <a href="#" class="shareCounter gapArticleActions" title="Share"><i class="statusCounterIcon-share"></i><span id="numS-<?php echo $rpStatusID; ?>"><?php echo $status->data->numberShared ?></span></a>

                                </span>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="postActionWrapper postItem-<?php echo $rpStatusID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $rpStatusID; ?>">
                    <?php
//                    $records = $mod['comment'][$statusID];
                    if ($status->data->numberLike > 0) {
                        if ($mod['likeStatus'][$statusID] == 'null') {
                            ?>
                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $status->data->numberLike; ?></a> people like this.</span>
                            </div>
                            <?php
                        } else {
                            if ($status->data->numberLike == 1) {
                                ?>
                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                    <span><i class="statusCounterIcon-like"></i>You like this</span>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                    <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $status->data->numberLike - 1; ?></a> people like this</span>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                    <?php
                    if ($mod['numberComments'][$statusID] > 3) {
                        ?>
                        <div class="whoCommentThisPost verGapBox" id="<?php echo $rpStatusID; ?>">
                            <span><i class="statusCounterIcon-comment"></i><a class="viewAll" href="">View all <?php echo $mod['numberComments'][$statusID]; ?> comments</a></span>
                            <span class="numberComments"><?php echo $mod['numberComments'][$statusID]; ?></span>
                        </div>
                        <?php
                    }
                    $f3 = require('viewComment.php');
                    ?>
                    <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $rpStatusID ?>">
                        <div class="large-10 uiActorCommentPicCol">
                            <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                        </div>
                        <div class="large-90 uiTextCommentArea">
                            <form class="ink-form" id="fmComment-<?php echo $rpStatusID ?>">
                                <fieldset>
                                    <div class="control-group">
                                        <div class="control">
                                            <input name="postID" type="hidden" value="<?php echo $rpStatusID ?>" />
                                            <textarea name="comment" class="taPostComment submitComment" id="textComment-<?php echo $rpStatusID ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-5 uiPostOption">
            <a href="" class="postOption" data-action=".optionPopUp"><i class="optionIcon-articlePost"></i></a>
            <div class="uiPostOptionPopUpOver uiBox-PopUp topRightArrow" data-target=".optionPopUp">
                <nav class="ink-navigation">
                    <ul class="menu vertical">
                        <li><a class="test" href="#">Report this post</a></li>
                        <li><a href="#">Option 1</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
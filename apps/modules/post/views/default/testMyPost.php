<?php
$listStatus = $this->f3->get('listStatus');
$comments = $this->f3->get('comments');
$numberOfComments = $this->f3->get('numberOfComments');
$currentUser = $this->f3->get('currentUser');
$otherUser = $this->f3->get('otherUser');
$likeStatus = $this->f3->get('likeStatus');
$statusFollow = $this->f3->get('statusFollow');
$statusFriendship = $this->f3->get('statusFriendShip');
$postActor = $this->f3->get('postActor');
$commentActor = $this->f3->get('commentActor');
$currentProfileID = $this->f3->get('currentProfileID');

$currentUserID = $currentUser->recordID;
$otherUserID = $otherUser->recordID;
?>
<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>post/webroot/js/socialewired.post.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".oembed2").oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 768,
                    autoplay: false
                });
        $(window).scroll(function() {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                $('.uiMoreView').show();
                var published = $(".uiBoxPostItem:last .uiBoxPostContainer .uiPostContent .articleSelectOption").find('.swTimeStatus').attr("name");
                var existNoMoreStatus = $('.noMoreStatus').length;
                console.log('sss', existNoMoreStatus);
                if (existNoMoreStatus == 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "/content/post/morePostStatus",
                        data: {published: published},
                        cache: false,
                        success: function(html) {
                            $("#contentContainer").append(html);
                            $('.uiMoreView').hide();
                        }
                    });
                } else {
                    $('.uiMoreView').hide();
                }
            }
        });
    });

</script>
<div class="uiMainColProfile large-70">
    <div class="uiMainContainer">
        <?php
        if ($statusFriendship == 'friend' || $currentUserID == $otherUserID)
            AppController::elementModules('postWrap', 'post');
        ?>
        <input name="profileID" id="profileID" type="hidden" value="<?php echo $currentProfileID; ?>">
        <div class="wrapperContainer">
            <div id="contentContainer">
                <?php
                if ($listStatus) {
                    for ($i = 0; $i < count($listStatus); $i++) {
                        $lastStatus = $listStatus[$i]->recordID;
                        $postID = str_replace(":", "_", $listStatus[$i]->recordID);
                        $actorProfile = $postActor[$listStatus[$i]->data->actor];
                        ?>
                        <div class="uiBoxPostItem">
                            <div class="uiBoxPostContainer column-group">
                                <div class="large-10 uiActorPicCol">
                                    <a href=""><img src="<?php echo $actorProfile->data->profilePic; ?>" /></a>
                                </div>
                                <div class="large-85 uiPostContent">
                                    <div class="articleActorName fixMarginBottom-5">
                                        <?php
                                        if ($listStatus[$i]->data->owner != $listStatus[$i]->data->actor) {
                                            $otherUserName = ucfirst($otherUser->data->firstName) . " " . ucfirst($otherUser->data->lastName);
                                            if (!$listStatus[$i]->data->contentShare) {
                                                if ($currentUserID != $listStatus[$i]->data->owner) {
                                                    ?>
                                                    <a href="" class="timeLineLink"><?php echo $listStatus[$i]->data->actorName; ?></a>  was posted in wall of <a href="" class="timeLineLink"> <?php echo $otherUserName; ?> </a>
                                                <?php } else {
                                                    ?>
                                                    <a href="" class="timeLineLink"><?php echo $listStatus[$i]->data->actorName; ?></a>  was posted in your wall
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <a href="" class="timeLineLink"><?php echo $otherUserName; ?> </a> was shared status of <a href=""><?php echo $listStatus[$i]->data->actorName; ?></a>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <a href="" class="timeLineLink"><?php echo $listStatus[$i]->data->actorName; ?></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="articleContentWrapper">
                                        <?php
                                        if (!$listStatus[$i]->data->contentShare || $listStatus[$i]->data->contentShare == 'none') {
                                            if (isset($listStatus[$i]->data->tagged) && $listStatus[$i]->data->tagged == 'none') {
                                                ?>
                                                <div class="textPostContainer fixMarginBottom-5">
                                                    <span class="textPost"><?php echo $listStatus[$i]->data->content; ?></span>
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="textPostContainer fixMarginBottom-5">
                                                    <span class="textPost">
                                                        <?php echo substr($listStatus[$i]->data->content, 0, strpos($listStatus[$i]->data->content, '_linkWith_')); ?>
                                                        <a href="<?php echo $listStatus[$i]->data->tagged; ?>"><?php echo $listStatus[$i]->data->tagged; ?></a>
                                                        <?php echo substr($listStatus[$i]->data->content, strpos($listStatus[$i]->data->content, '_linkWith_') + 10); ?>
                                                        <a href="<?php echo $listStatus[$i]->data->tagged; ?>" class="oembed5"> </a>
                                                    </span>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="textPostContainer fixMarginBottom-5">
                                                <span class="textPost"><?php echo $listStatus[$i]->data->contentShare; ?></span>
                                                <div class="attachmentStatus">
                                                    <span class="textPost"><?php echo $listStatus[$i]->data->content; ?></span>
                                                </div>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                    <div class="articleSelectOption">
                                        <div class="articleActions">
                                            <nav class="ink-navigation">
                                                <ul class="menu horizontal">
                                                    <!--Like Segments-->
                                                    <li>
                                                        <a class="likeSegments" id="likeLinkID-<?php echo $postID; ?>" name="likeStatus-<?php echo $likeStatus[$lastStatus]; ?>" title="Like post">Like</a>
                                                        <form class="likeHidden" id="likeHiddenID-<?php echo $postID; ?>">
                                                            <input type="hidden" name="id" value="<?php echo substr($otherUserID, strpos($otherUserID, ':') + 1); ?>">
                                                            <input type="hidden" name="statusID" value="<?php echo $postID; ?>">
                                                        </form>
                                                    </li>
                                                    <li class="gapArticleActions">.</li>
                                                    <!--Comment Segments-->
                                                    <li>
                                                        <a href="#" class="commentBtn" id="stream-<?php echo $postID; ?>" title="Comment to post">Comment</a>
                                                    </li>
                                                    <li class="gapArticleActions">.</li>
                                                    <?php
                                                    $mainStatus = str_replace(":", "_", $listStatus[$i]->data->mainStatus);
                                                    if ($listStatus[$i]->data->contentShare == 'none') {
                                                        ?>
                                                        <!--Share Segments-->
                                                        <li ><a class="shareStatus" onclick="ShareStatus('<?php echo $postID; ?>')" title="Share">Share</a></li>
                                                        <li class="gapArticleActions">.</li>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <!--Share Segments-->
                                                        <li ><a class="shareStatus" onclick="ShareStatus('<?php echo $mainStatus; ?>')" title="Share">Share</a></li>
                                                        <li class="gapArticleActions">.</li>
                                                        <?php
                                                    }
                                                    if ($currentUserID != $otherUserID || $listStatus[$i]->data->actor != $currentUserID) {
                                                        ?>
                                                        <!--Follow post Segments-->
                                                        <li>
                                                            <a class="followPostSegments" id="followID-<?php echo $postID; ?>" name="getStatus-<?php echo $statusFollow[$lastStatus]; ?>" title="Follow"></a>
                                                            <form class="followBtn" id="fmFollow-<?php echo $postID; ?>">
                                                                <input type="hidden" name="id" value="<?php echo substr($otherUserID, strpos($otherUserID, ':') + 1); ?>">
                                                                <input type="hidden" name="statusID" value="<?php echo $postID; ?>">
                                                            </form>
                                                        </li>
                                                        <li class="gapArticleActions">.</li>
                                                        <?php
                                                    }
                                                    ?>
                                                    <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $listStatus[$i]->data->published; ?>"></a></li>
                                                    <!----article post counter---->
                                                    <li class="rightFix">
                                                        <span>
                                                            <a href="#" class="likeCounter gapArticleActions" title="Like"><i class="statusCounterIcon-like"></i>6</a>
                                                            <a href="#" class="commentCounter gapArticleActions" title="Comment"><i class="statusCounterIcon-comment"></i>20</a>
                                                            <a href="#" class="shareCounter gapArticleActions" title="Share"><i class="statusCounterIcon-share"></i>3</a>
                                                            <a href="#" class="followPostCounter gapArticleActions" title="Follow Post"><i class="statusCounterIcon-followPost"></i>11</a>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="postActionWrapper postItem-<?php echo $postID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $postID; ?>">
                                            <?php
                                            if ($listStatus[$i]->data->numberLike > 0) {
                                                if ($likeStatus[$lastStatus] == 'null') {
                                                    ?>
                                                    <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postID; ?>">
                                                        <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $listStatus[$i]->data->numberLike; ?></a> people like this.</span>
                                                    </div>
                                                    <?php
                                                } else {
                                                    if ($listStatus[$i]->data->numberLike == 1) {
                                                        ?>
                                                        <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postID; ?>">
                                                            <span><i class="statusCounterIcon-like"></i>You like this</span>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postID; ?>">
                                                            <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $listStatus[$i]->data->numberLike - 1; ?></a> people like this</span>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                            <!--<div class="whoShareThisPost verGapBox">
                                                <span><i class="statusCounterIcon-share"></i><a href="">3 Shares</a></span>
                                            </div>
                                            <div class="whoCommentThisPost verGapBox">
                                                <span><i class="statusCounterIcon-comment"></i><a href="">View all 20 comments</a></span>
                                            </div>-->
                                            <?php
                                            if ($numberOfComments[$listStatus[$i]->recordID] > 3) {
                                                ?>
                                                <div class="whoCommentThisPost verGapBox" id="<?php echo $postID; ?>">
                                                    <span><i class="statusCounterIcon-comment"></i><a class="viewAll" href="">View all <?php echo $numberOfComments[$listStatus[$i]->recordID]; ?> comments</a></span>
                                                    <span class="numberComments"><?php echo $numberOfComments[$listStatus[$i]->recordID]; ?></span>
                                                </div>
                                                <?php
                                            }
                                            $records = $comments[$listStatus[$i]->recordID];
                                            //var_dump($comments);
                                            if (!empty($records)) {
                                                ?>
                                                <div class="commentContentWrapper">
                                                    <?php
                                                    $pos = (count($records) < 3 ? count($records) : 3);
                                                    for ($j = $pos - 1; $j >= 0; $j--) {
                                                        $user = $commentActor[$comments[$listStatus[$i]->recordID][$j]->data->actor];
                                                        $actorComment = $comments[$listStatus[$i]->recordID][$j]->data->actor_name;
                                                        $tagged = $comments[$listStatus[$i]->recordID][$j]->data->tagged;
                                                        $content = $comments[$listStatus[$i]->recordID][$j]->data->content;
                                                        $published = $comments[$listStatus[$i]->recordID][$j]->data->published;
                                                        ?>
                                                        <div class="eachCommentItem verGapBox column-group">
                                                            <div class="large-10 uiActorCommentPicCol">
                                                                <a href=""><img src="<?php echo $user->data->profilePic; ?>"></a>
                                                            </div>
                                                            <div class="large-85 uiCommentContent">
                                                                <p>
                                                                    <a class="timeLineCommentLink" href="/content/myPost?username=<?php //echo $actorComment;  ?>"><?php echo $actorComment; ?></a>
                                                                    <?php
                                                                    if ($tagged == 'none') {
                                                                        ?>
                                                                        <span class="textComment"><?php echo $content; ?></span>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <span class="textComment">
                                                                            <?php echo substr($content, 0, strpos($content, '_linkWith_')); ?>
                                                                            <a href="<?php echo $tagged; ?>"><?php echo $tagged; ?></a>
                                                                            <?php echo substr($content, strpos($content, '_linkWith_') + 10); ?>
                                                                            <a href="<?php echo $tagged; ?>" class="oembed5"> </a>
                                                                        </span>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </p>
                                                                <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    } // end for
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $postID ?>">
                                                <div class="large-10 uiActorCommentPicCol">
                                                    <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                                                </div>
                                                <div class="large-90 uiTextCommentArea">
                                                    <form class="ink-form" id="fmComment-<?php echo $postID ?>">
                                                        <fieldset>
                                                            <div class="control-group">
                                                                <div class="control">
                                                                    <input name="postID" type="hidden" value="<?php echo $postID ?>" />
                                                                    <textarea name="comment" class="taPostComment submitComment" id="textComment-<?php echo $postID ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
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
                        <?php
                    }
                }
                ?>
            </div>
            <div class="uiMoreView content-center">
                <div class="loading uiLoadingIcon"></div>
            </div>
        </div>
    </div>
</div>
<!--Other part-->
<div id="fade" class="black_overlay"></div>
<div class="uiShare uiPopUp"></div>
<div class="notificationShare uiPopUp">
    <div class="titlePopUp large-100">
        <span>Success</span>
    </div>
    <div class="mainPopUp large-100">
        <span class="successNotification">That status was shared on your timeline</span>
    </div>
</div>


   <div class="articleActorName fixMarginBottom-5">
                <?php if ($friendProfileID && $currentUserID != $friendProfileID) { ?>
                    <a class="timeLineLink" href="#"><?php echo $currentUserName; ?></a> was posted in wall of
                    <a class="timeLineLink" href=""><?php echo $friendName; ?></a>
                <?php } else { ?>
                    <a class="timeLineLink" href="#"><?php echo $currentUserName; ?></a>
                <?php } ?>
            </div>
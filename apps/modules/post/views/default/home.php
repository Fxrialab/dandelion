<?php
$currentUserID  = $currentUser->recordID;
if ($homeViews)
{
    $status     = $homeViews["actions"];
    $otherUserProfilePic  = $homeViews['otherUser_profilePic'];
    $actor      = $homeViews["actor"];
    $statusID   = $homeViews['statusID'];
    $comment    = $homeViews['comment'];
    $activityID = $homeViews['activityID'];
    $key        = $homeViews['key'];
    $numberComment  = $homeViews['numberComments'];
    $likeStatus     = $homeViews['likeStatus'];
    $statusFollow   = $homeViews['statusFollow'];
    $userCommentProfilePic    = $homeViews['userComment_profilePic'];
    $cm_username    = $homeViews['userComment_username'];
    $rpStatusID = str_replace(":", "_", $statusID);
    $status_owner   = $status->data->owner;
    $status_actor   = $status->data->actor;
    $status_username= $status->data->actorName;
    $status_tagged  = $status->data->tagged;
    $status_content = $status->data->content;
    $numberLikes    = $status->data->numberLike;
    $status_contentShare    = $status->data->contentShare;
    $status_published       = $status->data->published;
    $status_mainStatus      = str_replace(":", "_", $status->data->mainStatus);
?>
    <div class="uiBoxPostItem">
        <div class="uiBoxPostContainer column-group">
            <div class="large-10 uiActorPicCol">
                <?php
                if($status_actor != $currentUserID)
                {?>
                    <a href=""><img src="<?php echo $otherUserProfilePic; ?>"></a>
                <?php
                }else { ?>
                    <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                <?php }
                ?>
            </div>
            <div class="large-85 uiPostContent">
                <div class="articleActorName fixMarginBottom-5">
                    <?php
                    if($status_owner != $status_actor)
                    {
                        $otherUserName  = ucfirst($otherUser->data->firstName)." ".ucfirst($otherUser->data->lastName);
                        if(!$status_contentShare)
                        {
                            if($currentUserID != $status_owner)
                            {
                                ?>
                                <a href="" class="timeLineLink"><?php echo $status_username;?></a>  was posted in wall of <a href="" class="timeLineLink"> <?php echo $otherUserName; ?> </a>
                            <?php
                            }else { ?>
                                <a href="" class="timeLineLink"><?php echo $status_username;?></a>  was posted in your wall
                            <?php
                            }
                        } else{ ?>
                            <a href="" class="timeLineLink"><?php echo $otherUserName; ?> </a> was shared status of <a href=""><?php echo $status_username;?></a>
                        <?php
                        }
                    }else { ?>
                        <a href="" class="timeLineLink"><?php echo $status_username;?></a>
                    <?php
                    }
                    ?>
                </div>
                <div class="articleContentWrapper">
                    <?php
                    if(!$status_contentShare || $status_contentShare == 'none')
                    {
                        if($status_tagged =='none')
                        {?>
                            <div class="textPostContainer fixMarginBottom-5">
                                <span class="textPost"><?php echo $status_content; ?></span>
                            </div>
                        <?php
                        } else {  ?>
                            <div class="textPostContainer fixMarginBottom-5">
                                <span class="textPost">
                                    <?php echo substr($status_content,0,strpos($status_content,'_linkWith_')); ?>
                                    <a href="<?php echo $status_tagged; ?>"><?php echo $status_tagged; ?></a>
                                    <a href="<?php echo $status_tagged; ?>" class="oembed5"> </a>
                                </span>
                            </div>
                        <?php
                        }
                    } else { ?>
                        <div class="textPostContainer fixMarginBottom-5">
                            <span class="textPost"><?php echo $status_contentShare; ?></span>
                            <div class="attachmentStatus">
                                <span class="textPost"><?php echo $status_content; ?></span>
                            </div>
                        </div>
                    <?php
                    } ?>
                </div>
                <div class="articleSelectOption">
                    <div class="articleActions">
                        <nav class="ink-navigation">
                            <ul class="menu horizontal">
                                <!--Like Segments-->
                                <li>
                                    <a class="likeSegments" id="likeLinkID-<?php echo $rpStatusID; ?>" name="likeStatus-<?php echo $likeStatus[$statusID] ;?>" title="Like post"></a>
                                    <form class="likeHidden" id="likeHiddenID-<?php echo $rpStatusID; ?>">
                                        <input type="hidden" name="id" value="<?php echo substr($actor, strpos($actor, ':') + 1); ?>">
                                        <input type="hidden" name="statusID" value="<?php echo $rpStatusID; ?>">
                                    </form>
                                </li>
                                <li class="gapArticleActions">.</li>
                                <!--Comment Segments-->
                                <li>
                                    <a href="#" class="commentBtn" id="stream-<?php echo $rpStatusID;?>" title="Comment to post">Comment</a>
                                </li>
                                <li class="gapArticleActions">.</li>
                                <?php
                                if($status_contentShare == 'none')
                                {
                                ?>
                                    <!--Share Segments-->
                                    <li ><a class="shareStatus" onclick="ShareStatus('<?php echo $rpStatusID; ?>')" title="Share">Share</a></li>
                                    <li class="gapArticleActions">.</li>
                                <?php
                                }else {
                                ?>
                                    <!--Share Segments-->
                                    <li ><a class="shareStatus" onclick="ShareStatus('<?php echo $status_mainStatus; ?>')" title="Share">Share</a></li>
                                    <li class="gapArticleActions">.</li>
                                <?php
                                }
                                ?>
                                <?php
                                if($status_actor != $currentUserID)
                                {
                                ?>
                                    <!--Follow post Segments-->
                                    <li>
                                        <a class="followPostSegments" id="followID-<?php echo $rpStatusID; ?>" name="getStatus-<?php echo $statusFollow[$statusID] ;?>" title="Follow"></a>
                                        <form class="followBtn" id="fmFollow-<?php echo $rpStatusID; ?>">
                                            <input type="hidden" name="id" value="<?php echo substr($actor, strpos($actor, ':') + 1); ?>">
                                            <input type="hidden" name="statusID" value="<?php echo $rpStatusID; ?>">
                                        </form>
                                    </li>
                                    <li class="gapArticleActions">.</li>
                                <?php
                                }
                                ?>
                                <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $status_published; ?>"></a></li>
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
                    <div class="postActionWrapper postItem-<?php echo $rpStatusID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $rpStatusID; ?>">
                        <?php
                        //echo $numberLikes;
                        $records = $comment[$statusID];
                        if ($numberLikes > 0)
                        {
                            if ($likeStatus[$statusID] == 'null')
                            {
                                ?>
                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID;?>">
                                    <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $numberLikes; ?></a> people like this.</span>
                                </div>
                            <?php
                            }else {
                                if ($numberLikes == 1)
                                {
                                    ?>
                                    <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID;?>">
                                        <span><i class="statusCounterIcon-like"></i>You like this</span>
                                    </div>
                                <?php
                                }else {
                                    ?>
                                    <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID;?>">
                                        <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $numberLikes - 1; ?></a> people like this</span>
                                    </div>
                                <?php
                                }
                            }
                        }?>
                        <!--<div class="whoShareThisPost verGapBox">
                            <span><i class="statusCounterIcon-share"></i><a href="">3 Shares</a></span>
                        </div>-->
                        <?php
                        if ($numberComment[$statusID] > 3)
                        { ?>
                            <div class="whoCommentThisPost verGapBox" id="<?php echo $rpStatusID;?>">
                                <span><i class="statusCounterIcon-comment"></i><a class="viewAll" href="">View all <?php echo $numberComment[$statusID];?> comments</a></span>
                                <span class="numberComments"><?php echo $numberComment[$statusID];?></span>
                            </div>
                        <?php
                        }
                        if (!empty($records))
                        {
                        ?>
                            <div class="commentContentWrapper">
                            <?php
                            $pos = (count($records) < 3 ? count($records) : 3);
                            for($j = $pos - 1; $j >= 0; $j--)
                            {
                                $actorComment = $records[$j]->data->actor_name;
                                $tagged = $records[$j]->data->tagged;
                                $content= $records[$j]->data->content;
                                $published = $records[$j]->data->published;
                            ?>
                                <div class="eachCommentItem verGapBox column-group">
                                    <div class="large-10 uiActorCommentPicCol">
                                        <a href=""><img src="<?php echo $userCommentProfilePic; ?>"></a>
                                    </div>
                                    <div class="large-85 uiCommentContent">
                                        <p>
                                            <a class="timeLineCommentLink" href="/content/myPost?username=<?php echo $cm_username; ?>"><?php echo $actorComment; ?></a>
                                            <?php
                                            if($tagged =='none')
                                            {
                                                ?>
                                                <span class="textComment"><?php echo $content; ?></span>
                                            <?php
                                            } else {
                                                ?>
                                                <span class="textComment">
                                                    <?php echo substr($content,0,strpos($content,'_linkWith_')); ?>
                                                    <a href="<?php echo $tagged; ?>"><?php echo $tagged; ?></a>
                                                    <?php echo substr($content,strpos($content,'_linkWith_')+10); ?>
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
                        <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $rpStatusID?>">
                            <div class="large-10 uiActorCommentPicCol">
                                <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                            </div>
                            <div class="large-90 uiTextCommentArea">
                                <form class="ink-form" id="fmComment-<?php echo $rpStatusID?>">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="control">
                                                <input name="postID" type="hidden" value="<?php echo $rpStatusID?>" />
                                                <textarea name="comment" class="taPostComment submitComment" id="textComment-<?php echo $rpStatusID?>" spellcheck="false" placeholder="Write a comment..."></textarea>
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
?>
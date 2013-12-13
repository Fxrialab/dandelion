<?php
$currentUserID  = $currentUser->recordID;
if ($homeViews)
{
    $status     = $homeViews["actions"];
    $otherUser  = $homeViews['otherUser'];
    $actor      = $homeViews["actor"];
    $statusID   = $homeViews['statusID'];
    $comment    = $homeViews['comment'];
    $activityID = $homeViews['activityID'];
    $key        = $homeViews['key'];
    $numberComment  = $homeViews['numberComments'];
    $likeStatus     = $homeViews['likeStatus'];
    $statusFollow   = $homeViews['statusFollow'];
    $userComment    = $homeViews['userComment'];
    $rpStatusID = str_replace(":", "_", $statusID);
    $status_owner   = $status->data->owner;
    $status_actor   = $status->data->actor;
    $status_username= $status->data->actorName;
    $status_tagged  = $status->data->tagged;
    $status_content = $status->data->content;
    $numberLikes    = $status->data->numberLike;
    $status_contentShare    = $status->data->contentShare;
    $status_published       = $status->data->published;
    //var_dump($otherUser);
?>
    <div class="uiBoxPostItem">
        <div class="uiBoxPostContainer column-group">
            <div class="large-10 uiActorPicCol">
                <?php
                if($status_actor != $currentUserID)
                {?>
                    <a href=""><img src="<?php echo $otherUser->data->profilePic; ?>"></a>
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
                    if(!$status_contentShare)
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
                            <span class="textPost"><?php echo $status_content; ?></span>
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
                                <!--Share Segments-->
                                <li ><a href="#" title="Share"><i></i>Share</a></li>
                                <li class="gapArticleActions">.</li>
                                <!--Follow post Segments-->
                                <li><a href="#" title="Follow"><i></i>Follow Post</a></li>
                                <li class="gapArticleActions">.</li>
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
                    <div class="postActionWrapper uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $rpStatusID; ?>">
                        <!--<div class="whoShareThisPost verGapBox">
                            <span><i class="statusCounterIcon-share"></i><a href="">3 Shares</a></span>
                        </div>
                        <div class="whoCommentThisPost verGapBox">
                            <span><i class="statusCounterIcon-comment"></i><a href="">View all 20 comments</a></span>
                        </div>-->
                        <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $rpStatusID?>">
                            <div class="large-10 uiActorCommentPicCol">
                                <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                            </div>
                            <div class="large-90 uiTextCommentArea">
                                <form class="ink-form">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="control">
                                                <textarea class="taPostComment" spellcheck="false" placeholder="Write a comment..."></textarea>
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
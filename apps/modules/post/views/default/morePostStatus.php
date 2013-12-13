<?php
$rand               = rand(100,100000);
$currentUser        = $this->f3->get('currentUser');
$userProfileInfo    = $this->f3->get('userProfileInfo');
$likeStatus         = $this->f3->get('likeStatus');
$listStatus         = $this->f3->get('listStatus');
$comments           = $this->f3->get('comments');
$numberOfComments   = $this->f3->get('numberOfComments');
$statusFollow       = $this->f3->get('statusFollow');
$postActor          = $this->f3->get('postActor');
$commentActor       = $this->f3->get('commentActor');
$currentUserID      = $currentUser->recordID;
$userProfileID      = $userProfileInfo->recordID;
$userNameProfile    = ucfirst($userProfileInfo->data->firstName)." ".ucfirst($userProfileInfo->data->lastName);

if($listStatus)
{
    for ($i = 0; $i < count($listStatus); $i++)
    {
    $lastStatus = $listStatus[$i]->recordID;
    $postID = str_replace( ":" , "_", $listStatus[$i]->recordID);
    $actorProfile = $postActor[$listStatus[$i]->data->actor];
    ?>
        <div class="uiBoxPostItem">
            <div class="uiBoxPostContainer column-group">
                <div class="large-10 uiActorPicCol">
                    <a href=""><img src="<?php echo $actorProfile->data->profilePic; ?>"></a>
                </div>
                <div class="large-85 uiPostContent">
                    <div class="articleActorName fixMarginBottom-5">
                        <?php
                        if($listStatus[$i]->data->owner != $listStatus[$i]->data->actor)
                        {
                            if($currentUserID != $listStatus[$i]->data ->owner)
                            {
                            ?>
                                <a href="" class="timeLineLink"><?php echo $listStatus[$i]->data->actorName;?></a>  was posted in wall of <a href="" class="timeLineLink"> <?php echo $userNameProfile; ?> </a>
                            <?php
                            }else { ?>
                                <a href="" class="timeLineLink"><?php echo $listStatus[$i]->data->actorName;?></a>  was posted in your wall
                            <?php
                            }
                        }else { ?>
                            <a href="" class="timeLineLink"><?php echo $listStatus[$i]->data->actorName;?></a>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="articleContentWrapper">
                        <?php
                        if(!$listStatus[$i]->data->contentShare)
                        {
                            if($listStatus[$i]->data->tagged =='none')
                            {?>
                                <div class="textPostContainer fixMarginBottom-5">
                                    <span class="textPost"><?php echo $listStatus[$i]->data->content; ?></span>
                                </div>
                            <?php
                            } else {  ?>
                                <div class="textPostContainer fixMarginBottom-5">
                                    <span class="textPost">
                                        <?php echo substr($listStatus[$i]->data->content,0,strpos($listStatus[$i]->data->content,'_linkWith_')); ?>
                                        <a href="<?php echo $listStatus[$i]->data->tagged; ?>"><?php echo $listStatus[$i]->data->tagged; ?></a>
                                        <?php echo substr($listStatus[$i]->data->content,strpos($listStatus[$i]->data->content,'_linkWith_')+10); ?>
                                        <a href="<?php echo $listStatus[$i]->data->tagged; ?>" class="oembed5"> </a>
                                    </span>
                                </div>
                            <?php
                            }
                        } else { ?>
                            <div class="textPostContainer fixMarginBottom-5">
                                <span class="textPost"><?php echo $listStatus[$i]->data->contentShare; ?></span>
                                <span class="textPost"><?php echo $listStatus[$i]->data->content; ?></span>
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
                                        <a class="likeMorePostStatus" id="likeLinkID-<?php echo $postID; ?>" name="likeStatus-<?php echo $likeStatus[$lastStatus];?>" title="Like post"></a>
                                        <form class="likeHidden" id="likeHiddenID-<?php echo $postID; ?>">
                                            <input type="hidden" name="id" value="<?php echo substr($userProfileID, strpos($userProfileID, ':') + 1); ?>">
                                            <input type="hidden" name="statusID" value="<?php echo $postID; ?>">
                                        </form>
                                    </li>
                                    <li class="gapArticleActions">.</li>
                                    <!--Comment Segments-->
                                    <li>
                                        <a href="#" class="commentBtn" id="stream-<?php echo $postID;?>" title="Comment to post">Comment</a>
                                    </li>
                                    <li class="gapArticleActions">.</li>
                                    <!--Share Segments-->
                                    <li ><a href="#" title="Share"><i></i>Share</a></li>
                                    <li class="gapArticleActions">.</li>
                                    <!--Follow post Segments-->
                                    <li><a href="#" title="Follow"><i></i>Follow Post</a></li>
                                    <li class="gapArticleActions">.</li>
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
                        <div class="postActionWrapper uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $postID; ?>">
                            <!--<div class="whoShareThisPost verGapBox">
                                <span><i class="statusCounterIcon-share"></i><a href="">3 Shares</a></span>
                            </div>
                            <div class="whoCommentThisPost verGapBox">
                                <span><i class="statusCounterIcon-comment"></i><a href="">View all 20 comments</a></span>
                            </div>-->
                            <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $postID;?>">
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
}
?>
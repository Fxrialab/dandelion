<?php
$rand               = rand(100,100000);
$currentUser        = F3::get('currentUser');
$userProfileInfo    = F3::get('userProfileInfo');
$listStatus         = F3::get('listStatus');
$comments           = F3::get('comments');
$numberOfComments   = F3::get('numberOfComments');
$postActor          = F3::get('postActor');
$commentActor       = F3::get('commentActor');
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
    <li class="swStreamStory">
        <div class="storyContent">
            <a class="swStoryImage">
                <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $actorProfile->data->profilePic; ?>" />
            </a>
            <div class="mainWrapper">
                <h6 class="swStreamCaption">
                    <div class="actorName">
                        <?php
                        if($listStatus[$i]->data->owner != $listStatus[$i]->data->actor)
                        {
                            if($currentUserID != $listStatus[$i]->data ->owner)
                            {       ?>
                                <a href="#"><?php echo $listStatus[$i]->data->actorName;?></a>  was posted in wall of <a href=""> <?php echo $userNameProfile; ?> </a>
                            <?php
                            }else { ?>
                                <a href="#"><?php echo $listStatus[$i]->data->actorName;?></a>  was posted in your wall
                            <?php
                            }
                        }else { ?>
                            <a href=""><?php echo $listStatus[$i]->data->actorName;?></a>
                        <?php
                        } ?>
                    </div>
                </h6>
                <h6 class="swStreamMsg">
                    <?php
                    if(!$listStatus[$i]->data->contentShare)
                    {
                        if($listStatus[$i]->data->tagged =='none')
                        {?>
                            <span class="msgBody"><?php echo $listStatus[$i]->data->content; ?></span>
                        <?php
                        }else {  ?>
                            <span class="msgBody">
                                <div><?php echo substr($listStatus[$i]->data->content,0,strpos($listStatus[$i]->data->content,'_linkWith_')); ?>
                                    <a href="<?php echo $listStatus[$i]->data->tagged; ?>"><?php echo $listStatus[$i]->data->tagged; ?></a>
                                    <?php echo substr($listStatus[$i]->data->content,strpos($listStatus[$i]->data->content,'_linkWith_')+10); ?>
                                    <a href="<?php echo $listStatus[$i]->data->tagged; ?>" class="oembed<?php echo $rand ?>"> </a>
                                </div>
                            </span>
                        <?php
                        }
                    }else { ?>
                        <span class="msgBody"><?php echo $listStatus[$i]->data->contentShare; ?></span>
                        <span class="msgBodyShare"><?php echo $listStatus[$i]->data->content; ?></span>
                    <?php
                    } ?>
                </h6>
                <h6 class="swTimeStatus" title="<?php echo $listStatus[$i]->data->published; ?>">
                    <span> via web</span>
                </h6>

            </div>
            <div class="bottomWrapper">
                <ul class="swMsgControl">
                    <li class="link"><a href="" class="commentBtn" id="stream-<?php echo $postID;?>">Comment -</a></li>
                    <li class="link"><a href="">Share</a></li>
                    <?php
                        if ($currentUserID != $userProfileID)
                        {
                            if($listStatus[$i]->data->actor != $currentUser)
                            {       ?>
                                <!--<script type="text/javascript" src="<?php /*echo F3::get('STATIC'); */?>js/joinShare/follow.js"></script>-->
                                <div style="float: left;">
                                    <p class="btnFollow">
                                    <form class="followBtn" id="FollowID-<?php echo $postID; ?>">
                                        <input type="hidden" name="id" value="<?php echo substr($userProfileID, 2); ?>">
                                        <input type="hidden" name="statusID" value="<?php echo $postID; ?>">
                                        <input type="hidden" id="getURL" name="getURL" value="<?php echo F3::get('STATIC_MOD'); ?>">
                                        <button class='follow-button' id="followID-<?php echo $postID; ?>" name="getStatus-<?php //echo $statusFollow[$lastStatus] ;?>"  type="submit" ></button>
                                    </form>
                                    </p>
                                </div>
                                <?php
                            }
                        }
                    ?>

                </ul>
            </div>
            <div class="comment-wrapper">
            <?php
                $records = $comments[$listStatus[$i]->recordID];
                if ($numberOfComments[$listStatus[$i]->recordID] > 4)
                { ?>
                    <div class="view-more-comments" id="<?php echo $postID;?>">View all <?php echo $numberOfComments[$listStatus[$i]->recordID];?> comments</div>
                    <span class="hiddenSpan"><?php echo $numberOfComments[$listStatus[$i]->recordID];?></span>
                <?php
                }
                if (!empty($records))
                {
                    $pos = (count($records) < 4 ? count($records) : 4);
                    for($j = $pos - 1; $j >= 0; $j--)
                    {
                        $user = $commentActor[$comments[$listStatus[$i]->recordID][$j]->data->actor];
                    ?>
                    <div class="swCommentPosted">
                        <div class="swImg">
                            <img class="swCommentImg" src="<?php echo F3::get('BASE_URL'); ?><?php echo $user->data->profilePic; ?>" />
                        </div>
                        <div>
                            <?php
                                $actorID =  substr( $records[$j]->data->actor, strpos($records[$j]->data->actor, ":") + 1);
                                ?>
                            <a href="/profile?id=<?php echo $actorID;?>"><?php echo $records[$j]->data->actor_name?></a>
                            <label class="swPostedCommment">
                                <?php
                                if($records[$j]->data->tagged =='none')
                                {?>
                                <div><?php echo $records[$j]->data->content; ?></div>
                                <?php
                                } else {  ?>
                                <div>
                                    <?php echo substr($records[$j]->data->content,0,strpos($records[$j]->data->content,'_linkWith_')); ?>
                                    <a href="<?php echo $records[$j]->data->tagged; ?>"><?php echo $records[$j]->data->tagged; ?></a>
                                    <?php echo substr($records[$j]->data->content,strpos($records[$j]->data->content,'_linkWith_')+10); ?>
                                    <a href="<?php echo $records[$j]->data->tagged; ?>" class="oembed<?php echo $rand ?>"> </a>
                                </div>
                                <?php
                                } ?>
                            </label>
                            <label class="swTimeComment" title="<?php echo $records[$j]->data->published; ?>">via web</label>
                        </div>
                    </div>
            <?php }
            }?>
            </div>
            <div class="swCommentBox" id="commentBox-<?php echo $postID?>">
                <div class="swImg">
                    <img class="swCommentImg" src="<?php echo F3::get('BASE_URL'); ?><?php echo $currentUser->data->profilePic; ?>" />
                </div>
                <form class="swFormComment" id="formComment-<?php echo $postID?>">
                    <input name="postID" type="hidden" value="<?php echo $postID?>" />
                    <textarea class="swBoxCommment" name="comment" id="commentText-<?php echo $postID;?>"></textarea>
                    <input class="swSubmitComment" id="submitComment-<?php echo $postID?>" type="submit" value="Comment" />
                </form>
            </div>
        </div>
    </li>
        <?php
    }
}
?>
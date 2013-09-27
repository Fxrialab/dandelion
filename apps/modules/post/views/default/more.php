<?php

$activities     = F3::get('homeViews');
$currentUser    = F3::get('currentUser');
$rand           = rand(100,100000);
$currentUserID  = $currentUser->recordID;

if ($activities)
{
    $status     = $activities["actions"];
    $otherUser  = $activities['otherUser'];
    $actor      = $activities["actor"];
    $statusID   = $activities['statusID'];
    $comment    = $activities['comment'];
    $activityID = $activities['activityID'];
    $key        = $activities['key'];
    $numberComment  = $activities['numberComments'];
    $likeStatus     = $activities['likeStatus'];
    $statusFollow   = $activities['statusFollow'];
    $userComment    = $activities['userComment'];
    $rpStatusID = str_replace(":", "_", $statusID);
    $status_owner   = $status->data->owner;
    $status_actor   = $status->data->actor;
    $status_username= $status->data->actorName;
    $status_tagged  = $status->data->tagged;
    $status_content = $status->data->content;
    $status_contentShare    = $status->data->contentShare;
    $status_published       = $status->data->published;

    ?>

<!--<script type="text/javascript">
    $(document).ready(function(){
        $(".oembed<?php /*echo $rand */?>").oembed(null,
            {
                embedMethod: "append",
                maxWidth: 1024,
                maxHeight: 768,
                autoplay: false
            });
    })
</script>-->
<li class="swStreamStory">
    <input type="hidden" class="currentHome<?php echo $key ?>" value="<?php echo $activityID; ?>" />
    <div class="storyContent">
        <a class="swStoryImage">
            <?php
            if($status_actor != $currentUserID)
            {?>
                <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $otherUser->data->profilePic; ?>" />
            <?php
            }else { ?>
                <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $currentUser->data->profilePic; ?>" />
            <?php }
            ?>
        </a>
        <div class="mainWrapper">
            <h6 class="swStreamCaption">
                <div class="actorName">
                    <?php
                    if($status_owner != $status_actor)
                    {
                        if(!$status_contentShare)
                        {
                            if($currentUserID != $status_owner)
                            {
                                $otherUserName  = ucfirst($otherUser->data->firstName)." ".ucfirst($otherUser->data->lastName);
                                ?>
                                <a href=""><?php echo $status_username;?></a>  was posted in wall of <a href=""> <?php echo $otherUserName; ?> </a>
                            <?php
                            }else { ?>
                                <a href=""><?php echo $status_username;?></a>  was posted in your wall
                            <?php
                            }
                        } else{ ?>
                            <a href=""><?php echo $otherUserName; ?> </a> was shared status of <a href=""><?php echo $status_username;?></a>
                        <?php
                        }
                    }else { ?>
                        <a href=""><?php echo $status_username;?></a>
                    <?php
                    }
                    ?>
                </div>
            </h6>
            <h6 class="swStreamMsg">
                <?php if(!$status_contentShare){ ?>
                <span class="msgBody">
                    <?php  if($status_tagged =='none'){?>
                    <span class="msgBody"><div><?php echo $status_content; ?></div></span>
                    <?php } else {  ?>
                    <span class="msgBody">
                        <div>
                            <?php echo substr($status_content,0,strpos($status_content,'_linkWith_')); ?>
                            <a href="<?php echo $status_tagged; ?>"><?php echo $status_tagged; ?></a>
                            <?php echo substr($status_content,strpos($status_content,'_linkWith_')+10); ?>
                            <a href="<?php echo $status_tagged; ?>" class="oembed<?php echo $rand ?>"> </a>
                        </div>
                    </span>
                </span>
                <?php }} else { ?>
                <span class="msgBody"><?php echo $status_contentShare; ?></span>
                <span class="msgBodyShare"><?php echo $status_content; ?></span>
                <?php } ?>
            </h6>
            <h6 class="swTimeStatus" title="<?php echo $status_published; ?>">
                <span> via web</span>
            </h6>
        </div>
        <div class="bottomWrapper">
            <ul class="swMsgControl">
                <li class="link"><a class="likeMoreStatus" id="likeLinkID-<?php echo $rpStatusID; ?>" name="likeStatus-<?php echo $likeStatus[$statusID] ;?>"></a></li>
                <form class="likeHidden" id="likeHiddenID-<?php echo $rpStatusID; ?>">
                    <input type="hidden" name="id" value="<?php echo substr($actor, strpos($actor, ':') + 1); ?>">
                    <input type="hidden" name="statusID" value="<?php echo $rpStatusID; ?>">
                </form>
                <li class="link"><a href="" class="commentBtn" id="stream-<?php echo $rpStatusID;?>">Comment </a></li>
                <?php
                if(($status_owner != $currentUserID) && ($status_actor != $currentUserID)) {

                    if($status_actor != $currentUserID) {       ?>
                        <li class="link"><a class="shareStatus" onclick="ShareStatus('<?php echo $statusID; ?>')">- Share -</a></li>
                        <li class="link"><a class="followMoreStatus" id="followID-<?php echo $rpStatusID; ?>" name="getStatus-<?php echo $statusFollow[$statusID] ;?>"></a></li>
                        <form class="followBtn" id="FollowID-<?php echo $rpStatusID; ?>">
                            <input type="hidden" name="id" value="<?php echo substr($actor, strpos($actor, ':') + 1); ?>">
                            <input type="hidden" name="statusID" value="<?php echo $rpStatusID; ?>">
                        </form>
                        <?php
                    }}
                ?>
            </ul>
        </div>
        <div class="comment-wrapper">
            <?php
            $records = $comment[$statusID];

            if ($numberComment[$statusID] > 4) { ?>
                <div class="view-more-comments" id="<?php echo $rpStatusID;?>">View all <?php echo $numberComment[$statusID];?> comments</div>
                <span class="hiddenSpan"><?php echo $numberComment[$statusID];?></span>
                <?php } ?>

            <?php
            if (!empty($records)) {
                $pos = (count($records) < 4 ? count($records) : 4);
                for($j = $pos - 1; $j >= 0; $j--)
                {
                    $user = $userComment[$records[$j]->data->actor]
                    ?>
                    <div class="swCommentPosted">
                        <div class="swImg">
                            <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $user->data->profilePic; ?>" />
                        </div>
                        <div>
                            <?php
                            $actorID =  substr( $records[$j]->data->actor, strpos($records[$j]->data->actor, ":") + 1);
                            ?>
                            <a class="userComment" href="/profile?id=<?php echo $actorID;?>"><?php echo $records[$j]->data->actor_name?></a>
                            <label class="swPostedCommment">
                                <?php    if($records[$j]->data->tagged =='none'){?>
                                <div><?php echo $records[$j]->data->content; ?></div>
                                <?php } else {  ?>
                                <div>
                                    <?php echo substr($records[$j]->data->content,0,strpos($records[$j]->data->content,'_linkWith_')); ?>
                                    <a href="<?php echo $records[$j]->data->tagged; ?>"><?php echo $records[$j]->data->tagged; ?></a>
                                    <?php echo substr($records[$j]->data->content,strpos($records[$j]->data->content,'_linkWith_')+10); ?>
                                    <a href="<?php echo $records[$j]->data->tagged; ?>" class="oembed<?php echo $rand ?>"> </a>
                                </div>
                                <?php } ?>
                            </label>
                            <label class="swTimeComment" title="<?php echo $records[$j]->data->published; ?>">via web</label>
                        </div>
                    </div>
                    <?php } // end for
            } // end check empty?>
        </div>
        <div class="swCommentBox" id="commentBox-<?php echo $rpStatusID?>">
            <div class="swImg">
                <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $currentUser->data->profilePic; ?>" />
            </div>
            <form class="swFormComment" id="formComment-<?php echo $rpStatusID?>">
                <input name="postID" type="hidden" value="<?php echo $rpStatusID?>" />
                <textarea class="swBoxCommment" name="comment" id="commentText-<?php echo $rpStatusID;?>"></textarea>
                <input class="swSubmitComment" id="submitComment-<?php echo $rpStatusID?>" type="submit" value="Comment" />
            </form>
        </div>
    </div>
</li>
<?php
} // end check type for status
?>








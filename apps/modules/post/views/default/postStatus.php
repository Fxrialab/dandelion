<?php
/**
 * User: Hoc Nguyen
 * Date: 12/21/12
*/
$currentUser        = F3::get('currentUser');
$content            = F3::get('content');
$friendProfileInfo  = F3::get('friendProfileInfo');
$tagged             = F3::get('tagged');
$published          = F3::get('published');
$statusID           = str_replace( ":" , "_", F3::get('statusID'));
$rand               = rand(100,100000);

$currentUserID      = $currentUser->recordID;
$friendProfileID    = F3::get('friendProfileID');
$currentUserName    = ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);
$friendName         = ucfirst($friendProfileInfo->data->firstName)." ".ucfirst($friendProfileInfo->data->lastName);
?>
<script type="text/javascript">
    //append video tagged after post status by ajax
    $(document).ready(function(){
        $(".oembed<?php echo $rand ?>").oembed(null,
            {
                embedMethod: "append",
                maxWidth: 1024,
                maxHeight: 768,
                autoplay: false
            });
    })
</script>
<li class="swStreamStory">
    <div class="storyContent">
        <a class="swStoryImage">
            <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $currentUser->data->profilePic; ?>" />
        </a>
        <div class="mainWrapper">
            <h6 class="swStreamCaption">
                <div class="actorName">
                    <?php if($friendProfileID && $currentUserID != $friendProfileID){ ?>
                    <a href="#"><?php echo $currentUserName;?></a> was posted in wall of <a href=""><?php  echo $friendName; ?></a>
                    <?php } else { ?>
                    <a href="#"><?php echo $currentUserName; ?></a>
                    <?php } ?>
                </div>
            </h6>
            <h6 class="swStreamMsg">
                <span class="msgBody">
                <?php    if($tagged =='none'){?>
                         <span class="msgBody"><?php echo $content; ?></span>
                         <?php } else {  ?>
                         <span class="msgBody">
                            <div>
                                <?php echo substr($content,0,strpos($content,'_linkWith_')); ?>
                                <a href="<?php echo $tagged; ?>"><?php echo $tagged; ?></a>
                                <?php echo substr($content,strpos($content,'_linkWith_')+10); ?>
                                <a href="<?php echo $tagged; ?>" class="oembed<?php echo $rand ?>"> </a>
                            </div>
                         </span>
                         <?php } ?>
                </span>
            </h6>
            <h6 class="swTimeStatus" title="<?php echo $published; ?>">
                <span> via web</span>
            </h6>

        </div>
        <div class="bottomWrapper">
            <ul class="swMsgControl">
                <li class="link"><a class="likePostStatus" id="likeLinkID-<?php echo $statusID; ?>" name="likeStatus-null"></a></li>
                <form class="likeHidden" id="likeHiddenID-<?php echo $statusID; ?>">
                    <input type="hidden" name="id" value="<?php echo substr($currentUserID, strpos($currentUserID, ':') + 1); ?>">
                    <input type="hidden" name="statusID" value="<?php echo $statusID; ?>">
                </form>
                <li class="link"><a href="" class="commentBtn" id="stream-<?php echo $statusID;?>">- Comment </a></li>
<!--                <li class="link"><a href="">- Share</a></li>-->
            </ul>
        </div>
        <div class="tempLike-<?php echo $statusID; ?>"></div>
        <div class="swCommentBox" id="commentBox-<?php echo $statusID?>">
            <div class="swImg">
                <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $currentUser->data->profilePic; ?>" />
            </div>
            <form class="swFormComment" id="formComment-<?php echo $statusID?>">
                <input name="postID" type="hidden" value="<?php echo $statusID?>" />
                <textarea class="swBoxCommment" name="comment" id="commentText-<?php echo $statusID;?>"></textarea>
                <input class="swSubmitComment" id="submitComment-<?php echo $statusID?>" type="submit" value="Comment" />
            </form>
        </div>
    </div>
</li>

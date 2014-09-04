<?php
    $activities     = F3::get('homeViews');
    $currentUser    = F3::get('currentUser');
    $currentUserID  = $currentUser->recordID;
    if($activities)
    {
        $photo          = $activities["actions"];
        $actorName      = $activities["actor_name"];
        $photoFollow    = $activities['photoFollow'];
        $commentPhoto   = $activities['commentPhoto'];
        $numberComment  = $activities['numberComment'];
        $userComment   = $activities['userComment'];
        $actor          = $photo->data->owner;
        $photoID        = str_replace(":", "_", $activities["photo_id"]);
        $UserName       = F3::get('username');
        $otherUser      =F3::get('otherUser');
    }
?>

<li class="swStreamStory">
    <input type="hidden" class="currentHome<?php echo $activities['key'] ?>" value="<?php echo $activities['id'] ?>" />
    <div class="storyContent">
        <a class="swStoryImage">
            <?php
            if($actor != $currentUserID)
                //@todo get $currentUser equal to sessions edit avatar $currentUser immutability
                //@todo get $otherUser status post user is not a user to see the status of my
            {?>
                <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $otherUser->data->profilePic; ?>" />
                <?php
            }else {?>
                <img src="<?php echo F3::get('BASE_URL'); ?><?php echo $currentUser->data->profilePic; ?>" />
                <?php }
            ?>
        </a>
        <div class="mainWrapper">
            <h6 class="swStreamCaption">
                <div class="actorName">
                    <a href=""><?php echo $actorName;?></a>

                </div>
                <div class="descriptionPhoto">
                    <span class="description"><?php echo $photo->data->description;?></span>
                </div>
            </h6>
            <h6 class="swStreamMsg">
                <span class="msgBody"><img src="<?php echo $photo->data->url;?>" style="max-width: 450px;" /></span>
            </h6>
            <h6 class="swTimeStatus" title="<?php echo $photo->data->published; ?>">
                <span> via web</span>
            </h6>
        </div>
        <div class="bottomWrapper">
            <ul class="swMsgControl">
                <li class="link"><a href="" class="commentBtnphoto" id="stream-<?php echo $photoID;?>">Comment -</a></li>
                <li class="link"><a href="">Share</a></li>
                <?php
                if($actorName != $UserName)
                {
                    ?>
                    <div style="float: left;">
                        <p class="btnFollow">
                        <form class="followBtn" id="FollowID-<?php echo $photoID; ?>">
                            <input type="hidden" name="id" value="<?php echo substr($actor, strpos($actor, ':') + 1); ?>">
                            <input type="hidden" name="statusID" value="<?php echo $photoID; ?>">
                            <input type="hidden" id="getURL" name="getURL" value="<?php echo F3::get('STATIC_MOD'); ?>">
                            <button class='follow-button' id="followID-<?php echo $photoID; ?>" name="getStatus-<?php echo $photoFollow[$activities["photo_id"]] ;?>"  type="submit" ></button>
                        </form>
                        </p>
                    </div>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="comment-wrapper">
            <?php
            $records = $commentPhoto[$activities["photo_id"]];

            if ($numberComment[$activities["photo_id"]] > 4)
            {
                ?>
                <div class="view-more-comments" id="<?php echo $photoID?>">View all <?php echo $numberComment[$activities["photo_id"]];?> comments</div>
                <?php
            }
            ?>

            <?php
            if (!empty($records))
            {
                $pos    = (count($records) < 4 ? count($records) : 4);
                for($j  = $pos - 1; $j >= 0; $j--)
                {
                    $user   =   $userComment[$records[$j]->data->actor];
                    $avatar =   $user->data->profilePic;
                    ?>
                    <div class="swCommentPosted">
                        <div class="swImg">
                            <img class="swCommentImg" src="<?php echo F3::get('BASE_URL'); ?><?php echo $avatar;?>" />
                        </div>
                        <div>
                            <?php
                            $actorID =  substr( $records[$j]->data->actor, strpos($records[$j]->data->actor, ":") + 1);
                            ?>
                            <a class="userComment" href="/profile?id=<?php echo $actorID;?>"><?php echo $records[$j]->data->actor_name?></a>
                            <label class="swPostedCommment"><?php echo $records[$j]->data->content; ?></label>
                            <label class="swTimeComment" title="<?php echo $records[$j]->data->published; ?>">via web</label>
                        </div>
                    </div>
                    <?php } // end for
            } // end check empty
            ?>
        </div>
        <div class="swCommentBoxphoto" id="commentBoxphoto-<?php echo $photoID?>">
            <div class="swImg">
                <img class="swCommentImg" src="<?php echo $currentUser->data->profilePic; ?>" />
            </div>
            <form class="swFormCommentphoto" id="formCommentphoto-<?php echo $photoID?>">
                <input name="postID" type="hidden" value="<?php echo $photoID?>" />
                <textarea class="swBoxCommmentphoto" name="comment" id="commentTextphoto-<?php echo $photoID;?>"></textarea>
                <input class="swSubmitCommentphoto" id="submitCommentphoto-<?php echo $photoID?>" type="submit" value="Comment" />
            </form>
        </div>
    </div>
</li>





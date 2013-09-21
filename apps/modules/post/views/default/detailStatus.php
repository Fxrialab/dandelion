<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/19/13 - 3:13 PM
 * Project: joinShare Network - Version: 1.0
 */
$status         = F3::get('status_detail');
$comments       = F3::get('comment');
$UserName       = F3::get('currentUser');
$postID         = str_replace(":", "_", $status->recordID);
$userFriend     = F3::get('userFriend');
$statusFollow   = F3::get('statusFollow');
?>
<script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>post/webroot/js/socialewired.post.js"></script>
<div class="clear"></div>
<div class="clearfix" style="height:1px;"></div>
<div id="pagelet_stream" class="clearfix ">
    <div class="clearfix vertical fixed"></div>
    <div class="swStream">
        <ul id="swStreamStories" class="swList swStream swStream_Content">
            <?php
            if($status) { ?>

                <li class="swStreamStory">
                    <div class="storyContent">
                        <a class="swStoryImage">
                            <img src="<?php echo F3::get('STATIC'); ?>upload/noimage.jpg" />
                        </a>
                        <div class="mainWrapper">
                            <h6 class="swStreamCaption">
                                <div class="actorName">
                                    <?php if($status->data ->owner != $status->data ->actor) {
                                        if(!$status->data->contentShare){
                                            if($UserName->recordID != $status->data ->owner) {?>
                                                <a href=""><?php echo $status->data->actorName;?></a>  was posted in wall of <a href=""> <?php echo  $userFriend->data->firstName." ".$userFriend->data->lastName; ?> </a>
                                            <?php } else { ?>
                                                <a href=""><?php echo $status->data->actorName;?></a>  was posted in your wall
                                            <?php }} else{ ?>
                                            <a href=""><?php echo  $userFriend->data->firstName." ".$userFriend->data->lastName; ?> </a> was shared status of <a href=""><?php echo $status->data->actorName;?></a>
                                        <?php }} else{ ?>
                                        <a href=""><?php echo $status->data->actorName;?></a>
                                    <?php } ?>
                                </div>
                            </h6>
                            <h6 class="swStreamMsg">
                                <?php if(!$status->data->contentShare){
                                    if($status->data->tagged =='none'){?>
                                        <span class="msgBody"><div><?php echo $status->data->content; ?></div></span>
                                    <?php } else {  ?>
                                        <span class="msgBody">
                                <div>
                                    <?php echo substr($status->data->content,0,strpos($status->data->content,'_linkWith_')); ?>
                                    <a href="<?php echo $status->data->tagged; ?>"><?php echo $status->data->tagged; ?></a>
                                    <?php echo substr($status->data->content,strpos($status->data->content,'_linkWith_')+10); ?>
                                    <a href="<?php echo $status->data->tagged; ?>" class="oembed5"> </a>
                                </div>
                            </span>
                                    <?php }} else { ?>
                                    <span class="msgBody"><?php echo $status->data->contentShare; ?></span>
                                    <span class="msgBodyShare"><?php echo $status->data->content; ?></span>
                                <?php } ?>
                            </h6>
                            <h6 class="swTimeStatus" title="<?php echo $status->data->published; ?>">
                                <span> via web</span>
                            </h6>

                        </div>
                        <div class="bottomWrapper">
                            <ul class="swMsgControl">
                                <li class="link"><a href="" class="commentBtn" id="stream-<?php echo $postID;?>">Comment </a></li>
                                <?php
                                if(($status->data->owner != $UserName->recordID) && ($status->data->actor != $UserName->recordID)) {

                                    if($status->data ->actor != $UserName->recordID) {       ?>
                                        <li class="link"><a class="shareStatus" onclick="ShareStatus('<?php echo $postID; ?>')">- Share -</a></li>
                                        <li class="link"><a class="follow-button" id="followID-<?php echo $postID; ?>" name="getStatus-<?php echo $statusFollow[$lastStatus] ;?>"></a></li>
                                        <form class="followBtn" id="FollowID-<?php echo $postID; ?>">
                                            <input type="hidden" name="id" value="<?php echo substr($status->data ->actor, strpos($status->data ->actor, ':') + 1); ?>">
                                            <input type="hidden" name="statusID" value="<?php echo $postID; ?>">
                                        </form>
                                    <?php
                                    }}
                                ?>
                            </ul>
                        </div>
                        <div class="comment-wrapper">
                            <?php if ($comments) {
                                foreach($comments as $comment) {

                                    ?>
                                    <div class="swCommentPosted">
                                        <div class="swImg">
                                            <img class="swCommentImg" src="<?php echo F3::get('STATIC'); ?>upload/noimage.jpg" />
                                        </div>
                                        <div>
                                            <?php

                                            $actorID =  substr( $comment->data->actor, strpos($comment->data->actor, ":") + 1);
                                            ?>
                                            <a class="userComment" href="/profile?id=<?php echo $actorID;?>"><?php echo $comment->data->actor_name?></a>
                                            <label class="swPostedCommment">
                                                <?php    if($comment->data->tagged =='none'){?>
                                                    <div><?php echo $comment->data->content; ?></div>
                                                <?php } else {  ?>
                                                    <div>
                                                        <?php echo substr($comment->data->content,0,strpos($comment->data->content,'_linkWith_')); ?>
                                                        <a href="<?php echo $comment->data->tagged; ?>"><?php echo $comment->data->tagged; ?></a>
                                                        <?php echo substr($comment->data->content,strpos($comment->data->content,'_linkWith_')+10); ?>
                                                        <a href="<?php echo $comment->data->tagged; ?>" class="oembed5"> </a>
                                                    </div>
                                                <?php } ?>
                                            </label>
                                            <label class="swTimeComment" title="<?php echo $comment->data->published; ?>">via web</label>
                                        </div>
                                    </div>

                                <?php } } ?>
                        </div>
                        <div class="swCommentBox" id="commentBox-<?php echo $postID?>">
                            <div class="swImg">
                                <img class="swCommentImg" src="<?php echo F3::get('STATIC'); ?>upload/noimage.jpg" />
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
            ?>
        </ul>
    </div>
</div>
<div id="shareStatus" title="Share Status"></div>
<script type="text/javascript">
    /*$('.showImage').show();
    $('#fade').show();*/
</script>
<div id="fadea"></div>
<div class="showImage">
    <?php
        $photosJson          = F3::get("photosJson");
        $numberPhotos        = F3::get('numberPhoto');
        $album_id            = F3::get("album_id");
        $commentsJson        = F3::get("commentsJson");
        $urlsJson            = F3::get("urlsJson");
        $comments            = F3::get("commentsOfPhoto");
        $photos              = F3::get("photos");
        $itemPhoto           = F3::get("itemPhoto");
        $key                 = F3::get('key');
        ?>

    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/pretty.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/vendor/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.iframe-transport.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.fileupload.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/socialewired.photo.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/socialewired.followbtn.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC_MOD'); ?>photo/webroot/js/socialewired.postpt.js"></script>
    <script>
        var comments    = <?php echo $commentsJson?>;
        var photos      = <?php echo $photosJson ?>;
        var urls        = <?php echo $urlsJson ?>;
        var photoIndex  = <?php echo $key ?>;//@todo vi tri thu may trong bang photo
        var countPhotos = photos.length;
        //photoIndex lay key cua $getAlbum dk so cuoi cung recordID= get url albumID
        //@todo: add check null for "urls" (in js)
    </script>
    <div id="containerViewPhoto">
        <div id="headderVP">
            <input type="hidden" id="numberPhoto" value="<?php echo $numberPhotos;?>">
            <span class="nextPrevious" style="z-index: 10000;position: absolute;top: 230px">
                <a class="prev" id="previous-photo" title="Previous Photo">‹</a>
                <a class="next" id="next-photo" title="Next Photo">›</a>
            </span>
            <?php
            if($album_id)
            {
                ?>
                <a class="backBtn" href="/content/photo/viewAlbum?id=<?php echo $album_id;?>"><span class="close">×</span></a>
                <?php
            }
            else
            {
                ?>
                <a class="backBtn" href="/content/myPhoto"><span class="close">×</span> </a>
                <?php
            }
            ?>
        </div>
        <div id="images-container">
        </div>
        <script>
            if (photos.length > 0)
                {
                    var firstUrl    = photos[photoIndex].url;
                    var image       = document.createElement('img');
                    image.src       = firstUrl;
                    image.className = "photo-selected";
                    console.log(firstUrl);
                    //$(".dtDescription").html(photos[photoIndex].description);
                    $("#images-container").append(image);
                }
        </script>
        <div class="infoUserPost">
            <img class="imgInfoUserPost" src="<?php echo F3::get('STATIC')?>upload/noimage.jpg">
            <div class="wrapperInfo">
                <span class="userPostImage">huong nguyen</span><br />
                <span class="timePostImage">1hours ago</span>
            </div>
        </div>
        <div class="rowInfoPhoto">
            <div class="descriptionVP">
            <?php
            if($photos)
            {
                for($i=0; $i < count($photos); $i ++)
                {
                    $description = $photos[$i]->data->description;
                    $idPhoto     = str_replace(':', '_', $photos[$i]->recordID);
                    if($description != '')
                    {
                        ?>
                        <span class="description-<?php echo $idPhoto; ?>" style="display: none;"><?php echo $description; ?></span>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a class="dtDescription description-<?php echo $idPhoto; ?>" style="display: none;">Add Description</a>
                        <?php
                    }
                }
            }
            ?>
            </div>
            <div class="BoxDescription">
                <form id="descriptionPhoto">
                    <textarea name="contentDescription" rows="" cols="" class="contentDescription" placeholder="Add description for photo">

                    </textarea>
                    <input type="hidden" id="getPhotoID" class="descriptionID" value="" name="photoID">
                    <input type="submit" class="saveDescription" value="Save">
                    <a class="cancelDescription">Cancel</a>
                </form>
            </div>
            <div class="bottomWrapper">
                <ul class="swMsgControl" style="margin-top: 0px;">
                    <li class="link"><a href="" class="commentBtnphoto" id="stream">Comment -</a></li>
                    <li class="link"><a href="">Share</a></li>
                    <!--
                    <div style="float: left;">
                        <p class="btnFollow">
                        <form class="followBtn" id="FollowID-">
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="statusID" value="">
                            <input type="hidden" id="getURL" name="getURL" value="<?php echo F3::get('STATIC'); ?>">
                            <button class='follow-button' id="followID-1" name="getStatus-"  type="submit" ></button>
                        </form>
                        </p>
                    </div>    -->
                </ul>
            </div>
        </div>
        <div class="wrapper-comment">
            <div class="comment-wrapper" style="margin: 0">
                <script>
                    records = comments[photoIndex];
                </script>
                <?php
                // @todo: load comment here
                //$records = $comments[];
                /*if ($numberOfComments[$activity["post_id"]] > 4) { ?>
                  <div class="view-more-comments" id="<?php echo $postID?>">View all <?php echo $numberOfComments[$activity["post_id"]];?> comments</div>
               <?php }*/ ?>

                <?php
                if($photos) {
                    foreach($photos as $getPhotoID)
                    {
                        $id = $getPhotoID->recordID;
                        if($comments[$id] != null)
                        {
                            $record = $comments[$id];
                            if (count($record) > 4)
                            {
                                ?>
                                <div class="viewMoreComments" id="<?php echo str_replace(':', '_', $id);?>">View all <span class="numberComments"><?php echo count($record);?></span> comments</div>
                                <?php
                            }
                            foreach($comments[$id] as $comment)
                            {
                                ?>
                                <div class="swCommentPosted <?php echo str_replace(':', '_', $id); ?>" style="display: none; margin: 0; border-bottom:1px solid white">
                                    <div class="swImg">
                                        <img class="swCommentImg" src="<?php echo F3::get('STATIC'); ?>upload/noimage.jpg" />
                                    </div>
                                    <div>
                                        <?php
                                        $actorID =  substr($comment->data->actor, strpos($comment->data->actor, ":") + 1);
                                        ?>
                                        <a class="userComment" href="/profile?id=<?php echo $actorID;?>"><?php echo $comment->data->actor_name?></a>
                                        <label class="swPostedCommment"><?php echo $comment->data->content; ?></label>
                                        <label class="swTimeComment" title="<?php echo $comment->data->published; ?>"></label>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                }
                ?>
            </div>
            <div class="swCommentBoxphoto" id="commentBoxphoto" style="float: left; margin: 0">
                <div class="swImg">
                    <img class="swCommentImg" src="<?php echo F3::get('STATIC'); ?>upload/noimage.jpg" />
                </div>
                <form class="swFormCommentphoto" id="formCommentphoto">
                    <input name="postID" class="photoID" type="hidden" value="" />
                    <textarea class="swBoxCommmentphoto" name="comment" id="commentTextphoto" style="width:290px;"></textarea>
                    <input class="swSubmitCommentphoto" id="submitCommentphoto" type="submit" value="Comment" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php
foreach(glob(MODULES.'photo/webroot/js/jshome.php') as $jshome)
{
    if(file_exists($jshome)){
        require_once ($jshome);
    }
}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#greenBar').removeClass('fix_elem');
        //$('body').css('overflow','hidden');
    });
</script>
<div id="fadea"></div>
<div class="showImage">
    <?php
    $photosJson         = F3::get("photosJson");
    $numberPhotos       = F3::get('numberPhoto');
    $album_id           = F3::get("album_id");

    $urlsJson           = F3::get("urlsJson");
    $comments           = F3::get("commentsOfPhoto");
    $commentActor       = F3::get("commentActor");
    $photos             = F3::get("photos");
    //$itemPhoto           = F3::get("itemPhoto");
    $key                = F3::get('key');
    $infoActorPhotoUser = F3::get('infoActorPhotoUser');
    $currentUser        = F3::get('currentUser');

    ?>

    <script>
        //var comments    = <?php //echo $commentsJson?>;
        var photos      = <?php echo $photosJson ?>;
        var urls        = <?php echo $urlsJson ?>;
        var photoIndex  = <?php echo $key ?>;//@todo vi tri thu may trong bang photo
        var countPhotos = photos.length;
        //console.log('count', countPhotos);
        //photoIndex lay key cua $getAlbum dk so cuoi cung recordID= get url albumID
        //@todo: add check null for "urls" (in js)
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            currentPhotoID = photos[photoIndex].recordID.replace(':','_');
            //show box add description if current photo exist add description
            $('.description-'+currentPhotoID).click(function() {
                $('.BoxDescription-'+currentPhotoID).css('display', 'block');
            });
            addDescription(currentPhotoID);
            $('.cancelDescription').click(function() {
                $('.BoxDescription-'+currentPhotoID).css('display', 'none');
            });

            // preload others
            if (typeof(urls) != 'undefined') {
                $("#images-container").preload(urls, photos);
            }
        });
    </script>

    <div id="containerViewPhoto">
        <div id="headderVP">
            <input type="hidden" id="numberPhoto" value="<?php echo $numberPhotos;?>">
            <span class="nextPrevious" style="z-index: 10000;position: absolute;top: 230px">
                <a class="prev" id="previous-photo" title="Previous Photo">&lt;</a>
                <a class="next" id="next-photo" title="Next Photo">&gt;</a>
            </span>
            <?php
            if($album_id != 'none')
            {
                ?>
                <a class="backBtn" href="/content/photo/viewAlbum?albumID=<?php echo $album_id;?>"><span class="close">x</span></a>
                <?php
            }
            else
            {
                ?>
                <a class="backBtn" href="/content/myPhoto"><span class="close">x</span> </a>
                <?php
            }
            ?>
        </div>
        <div id="images-container">
        </div>
        <script>
            $(document).ready(function(){
                if (photos.length > 0)
                {
                    var curPhotoRecordID = photos[photoIndex].recordID.replace(':','_');
                    $('#'+curPhotoRecordID).removeClass('photo-unselected');
                    $('#'+curPhotoRecordID).addClass('photo-selected');
                    $('#contentPhotoItem'+curPhotoRecordID).removeClass('invisiblePhotoWrap');
                    $('#contentPhotoItem'+curPhotoRecordID).addClass('visiblePhotoWrap');
                }
            });

        </script>
        <?php
        if($photos ){
            for($i=0; $i < count($photos); $i ++)
            {
                $description = $photos[$i]->data->description;
                $numberComments = $photos[$i]->data->numberComment;
                $photoID     = str_replace(':', '_', $photos[$i]->recordID);
                $actorPhotoName = ucfirst($infoActorPhotoUser[$photos[$i]->data->actor]->data->firstName)." ".ucfirst($infoActorPhotoUser[$photos[$i]->data->actor]->data->lastName);
                $profilePicActorPhoto = $infoActorPhotoUser[$photos[$i]->data->actor]->data->profilePic;
                //echo $profilePicActorPhoto;
            ?>
                <div id="contentPhotoItem<?php echo $photoID; ?>" class="invisiblePhotoWrap">
                    <div class="infoUserPost">
                        <img class="imgInfoUserPost" src="<?php echo $profilePicActorPhoto;?>">
                        <div class="wrapperInfo">
                            <span class="userPostImage"><?php echo $actorPhotoName;?></span><br />
                            <span class="timePostImage">1hours ago</span>
                        </div>
                    </div>

                    <div class="rowInfoPhoto">
                        <div class="descriptionVP">
                            <?php
                            if($description != '')
                            {
                                ?>
                                <span class="description-<?php echo $photoID; ?>"><?php echo $description; ?></span>
                            <?php
                            }
                            else
                            {
                                ?>
                                <a class="dtDescription description-<?php echo $photoID; ?>">Add Description</a>
                                <div class="BoxDescription-<?php echo $photoID;?>" style="display: none">
                                    <form id="descriptionPhoto<?php echo $photoID;?>">
                                        <textarea name="contentDescription" rows="" cols="" class="contentDescription textDes<?php echo $photoID;?>" placeholder="Add description for photo"></textarea>
                                        <a class="saveDescription saveDescription-<?php echo $photoID;?>">Save</a>
                                        <a class="cancelDescription">Cancel</a>
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="bottomWrapper">
                            <ul class="swMsgControl">
                                <li class="link"><a class="likeLink" id="likeLinkID-<?php echo $photoID; ?>" name="likeStatus-null"></a></li>
                                <form class="likeHidden" id="likeHiddenID-<?php echo $photoID; ?>">
                                    <input type="hidden" name="id" value="">
                                    <input type="hidden" name="statusID" value="<?php echo $photoID; ?>">
                                </form>
                                <li class="link"><a href="" class="commentBtnPhoto" id="stream-<?php echo $photoID; ?>">- Comment </a></li>
                                <li class="link"><a class="shareStatus" onclick="ShareStatus('')">- Share -</a></li>
                                <li class="link"><a class="follow-button" id="followID-" name="getStatus-null"></a></li>
                                <form class="followBtn" id="FollowID-">
                                    <input type="hidden" name="id" value="">
                                    <input type="hidden" name="statusID" value="">
                                </form>
                            </ul>
                        </div>
                        <div class="comment-wrapper fixedClear" id="showComment-<?php echo $photoID; ?>">
                        <?php
                        $records = $comments[$photos[$i]->recordID];
                        if ($numberComments > 4) { ?>
                        <div class="view-more-commentPhoto" id="<?php echo $photoID;?>">View all <?php echo $numberComments;?> comments</div>
                        <span class="hiddenSpan"><?php echo $numberComments;?></span>
                        <?php } ?>
                        <?php
                        if (!empty($records)) {
                            $pos = (count($records) < 4 ? count($records) : 4);
                            for($j = $pos - 1; $j >= 0; $j--)
                            {
                                $user = $commentActor[$comments[$photos[$i]->recordID][$j]->data->actor];

                                ?>
                                <div class="swCommentPostedPhoto">
                                    <div class="swImg">
                                        <img width="30" height="30" src="<?php echo $user->data->profilePic; ?>" />
                                    </div>
                                    <div class="commentContentPhoto">
                                        <?php
                                        $actorID =  substr( $records[$j]->data->actor, strpos($records[$j]->data->actor, ":") + 1);
                                        ?>
                                        <a class="userComment" href="/profile?id=<?php echo $actorID;?>"><?php echo $records[$j]->data->actor_name?></a>
                                        <label class="swPostedCommment">
                                            <div><?php echo $records[$j]->data->content; ?></div>

                                        </label>
                                        <label class="swTimeComment" title="<?php echo $records[$j]->data->published; ?>">via web</label>
                                    </div>
                                </div>
                            <?php }
                        }?>
                        </div>
                    </div>
                    <div class="swCommentBoxphoto" id="commentBoxPhoto-<?php echo $photoID; ?>" style="float: left; margin: 0">
                        <div class="swImg">
                            <img class="swCommentImg" src="<?php echo $currentUser->data->profilePic; ?>" />
                        </div>
                        <form class="swFormCommentphoto" id="formCommentPhoto-<?php echo $photoID; ?>">
                            <input name="photoID" class="photoID<?php echo $photoID; ?>" type="hidden" value="<?php echo $photoID; ?>" />
                            <textarea class="swBoxCommmentphoto" name="comment" id="commentTextPhoto-<?php echo $photoID; ?>" style="width:272px;"></textarea>
                            <input class="swSubmitCommentPhoto" id="submitCommentPhoto-<?php echo $photoID; ?>" type="submit" value="Comment" />
                        </form>
                    </div>
                </div>
            <?php
            }
        }
        ?>
        </div>
</div>

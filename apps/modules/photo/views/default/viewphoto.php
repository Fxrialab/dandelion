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
        $('body').css('overflow','hidden');
    });
</script>
<div id="fadea"></div>
<div class="showImage">
    <?php
    $photosJson         = F3::get("photosJson");
    $numberPhotos       = F3::get('numberPhoto');
    $album_id           = F3::get("album_id");
    //$commentsJson        = F3::get("commentsJson");
    $urlsJson           = F3::get("urlsJson");
    //$comments            = F3::get("commentsOfPhoto");
    $photos             = F3::get("photos");
    //$itemPhoto           = F3::get("itemPhoto");
    $key                = F3::get('key');
    $infoActorPhotoUser = F3::get('infoActorPhotoUser');
    ?>

    <script>
        //var comments    = <?php //echo $commentsJson?>;
        var photos      = <?php echo $photosJson ?>;
        var urls        = <?php echo $urlsJson ?>;
        var photoIndex  = <?php echo $key ?>;//@todo vi tri thu may trong bang photo
        var countPhotos = photos.length;
        console.log('count', countPhotos);
        //photoIndex lay key cua $getAlbum dk so cuoi cung recordID= get url albumID
        //@todo: add check null for "urls" (in js)
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
        if($photos )
        {
            for($i=0; $i < count($photos); $i ++)
            {
                $description = $photos[$i]->data->description;
                $photoID     = str_replace(':', '_', $photos[$i]->recordID);
                //var_dump($infoActorPhotoUser);
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
                                <span class="description-<?php echo $photoID; ?>" style="display: none;"><?php echo $description; ?></span>
                            <?php
                            }
                            else
                            {
                                ?>
                                <a class="dtDescription description-<?php echo $photoID; ?>" style="display: none;">Add Description</a>
                            <?php
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
            <?php
            }
        }
        ?>
        </div>
</div>

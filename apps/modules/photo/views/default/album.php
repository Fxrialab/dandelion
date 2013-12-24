<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>photo/webroot/js/photo.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>photo/webroot/js/jquery.uploadfile.min.js"></script>
<?php
$albumID    = $this->f3->get('albumID');
$photos     = $this->f3->get("photos");
?>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <div class="uiBoxTitle large-100 column-group">
            <div class="uiLeftPhotoBreadcrumbs large-50">
                <nav class="ink-navigation">
                    <ul class="breadcrumbs">
                        <li><a href="#">Photo</a></li>
                        <li class="active"><a href="#">View Album</a></li>
                    </ul>
                </nav>
            </div>
            <div class="uiRightPhotoTab large-50">
                <nav class="ink-navigation">
                    <ul class="menu horizontal push-right">
                        <li><a href="/content/myPhoto" class="uiMediumButton white">Your Photos</a></li>
                        <li><a href="/content/photo/myAlbum" class="uiMediumButton white">Albums</a></li>
                        <li><a href="" class="uiMediumButton white">Not Tagged</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="uiPhotoContainer uiBox-PopUp albumBoxArrow">
            <div class="uiPhotoActionsBox column-group">
                <div class="large-20 uiUploadPhotoButton"><a class="uploadPhoto uiMediumButton orange">Upload Photo</a></div>
            </div>
            <div class="uiPinLayoutPhotoWrapper">
                <div class="uiPhotoPinCol">
                    <?php
                    if($photos)
                    {
                        for ($i = 0; $i < count($photos); $i++)
                        {
                            $photoID = substr($photos[$i]->recordID, strpos($photos[$i]->recordID, ':') + 1);
                            $photoURL= $photos[$i]->data->url;
                            ?>
                            <div class="pinItems">
                                <div class="photoItems">
                                    <a href="/content/photo/viewPhoto?photoID=<?php echo $photoID; ?>"><img src="<?php echo $photoURL; ?>"></a>
                                </div>
                                <div class="photoSelectOptions column-group">
                                    <nav class="ink-navigation">
                                        <ul class="menu horizontal">
                                            <li><a href=""><i class="photoNavIcon-like"></i>23</a></li>
                                            <li><a href=""><i class="photoNavIcon-comment"></i> 54</a></li>
                                            <li><a href=""><i class="photoNavIcon-share"></i> 5</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="whoLikeThisPost uiBox-PopUp boxLikeTopLeftArrow">
                                    <span><a href="">Facebook</a>, <a href="">Google</a> and <a href="">4</a> people like this.</span>
                                </div>
                                <div class="whoShareThisPost verGapBox">
                                    <span><a href="">3 Shares</a></span>
                                </div>
                                <div class="whoCommentThisPost verGapBox">
                                    <span><a href="">View all 20 comments</a></span>
                                </div>
                                <div class="commentContentWrapper">
                                    <div class="eachCommentItem verGapBox column-group">
                                        <div class="large-20 uiActorCommentPicCol">
                                            <a href=""><img src="../webroot/images/avar.jpg"></a>
                                        </div>
                                        <div class="large-75 uiCommentContent">
                                            <p>
                                                <a class="timeLineCommentLink" href="">Google</a>
                                                <span class="textComment">It's impossible not to love this guys!! Glory Glory Man United!!</span>
                                            </p>
                                            <span><a class="linkColor-999999" href="">20 minutes ago</a></span>
                                        </div>
                                    </div>
                                    <div class="eachCommentItem verGapBox column-group">
                                        <div class="large-20 uiActorCommentPicCol">
                                            <a href=""><img src="../webroot/images/avar.jpg"></a>
                                        </div>
                                        <div class="large-75 uiCommentContent">
                                            <p>
                                                <a class="timeLineCommentLink" href="">Facebook</a>
                                                <span class="textComment">It's awesome!</span>
                                            </p>
                                            <span><a class="linkColor-999999" href="">4 minutes ago</a></span>
                                        </div>
                                        <div class="large-5 uiCommentOption">

                                        </div>
                                    </div>
                                </div>
                                <div class="uiStreamCommentBox verGapBox column-group">
                                    <div class="large-20 uiActorCommentPicCol">
                                        <a href=""><img src="../webroot/images/avar.jpg"></a>
                                    </div>
                                    <div class="large-80 uiTextCommentArea">
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
                        <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Other part-->
<div id="fade" class="black_overlay"></div>
<div class="uiLightUpload uiPopUp">
    <div class="containerPhotoPopUp">
        <div class="actionUpload">
            <input name="album_id" id="albumID" value="<?php echo $albumID; ?>" type="hidden">
            <div id="mulitplefileuploader">Select Files</div>
            <div class="photoActionBtn">
                <div class="qualityOption">
                    <input type="checkbox" id="cbQualityPhoto" class="uncheck" value="" name="qualityPhoto">
                    <label>High Quality</label>
                </div>
                <div class="actionUploadBtn">
                    <label for="" id="cancelUpload" class="actionFileUpload">Cancel</label>
                </div>
                <div class="actionUploadBtn">
                    <label for="" id="uploadPhoto" class="actionFileUpload">Upload</label>
                </div>
            </div>
        </div>
        <div id="displayPhotos"></div>
        <div id="status"></div>
    </div>
</div>
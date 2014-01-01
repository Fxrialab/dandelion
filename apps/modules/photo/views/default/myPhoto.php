<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>photo/webroot/js/photo.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>photo/webroot/js/jquery.uploadfile.min.js"></script>
<?php
$otherUser  = $this->f3->get('otherUser');
$currentUser= $this->f3->get('currentUser');
$photos     = $this->f3->get('photos');
$likeStatus = $this->f3->get('likeStatus');
$comments   = $this->f3->get('comments');
$commentActor   = $this->f3->get('commentActor');
$otherUserID = $otherUser->recordID;
?>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <div class="uiBoxTitle large-100 column-group">
            <div class="uiLeftPhotoBreadcrumbs large-50">
                <nav class="ink-navigation">
                    <ul class="breadcrumbs">
                        <li><a href="/content/myPhoto">Photo</a></li>
                        <li class="active"><a href="/content/myPhoto">Your Photo</a></li>
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
        <div class="uiPhotoContainer uiBox-PopUp yourPhotoBoxArrow">
            <div class="uiPhotoActionsBox column-group">
                <div class="large-20 uiUploadPhotoButton"><a class="uploadPhoto uiMediumButton orange">Upload Photo</a></div>
                <div class="large-20 uiCreateAlbumButton"><a class="createAlbum uiMediumButton orange">Create Album</a></div>
            </div>
            <div class="uiPinLayoutPhotoWrapper">
                <div class="uiPhotoPinCol">
                    <?php
                    if($photos)
                    {
                        for ($i = 0; $i < count($photos); $i++)
                        {
                            $photoID = substr($photos[$i]->recordID, strpos($photos[$i]->recordID, ':') + 1);
                            $postPhotoID  = str_replace(':', '_',$photos[$i]->recordID);
                            $photoURL= $photos[$i]->data->url;
                            $description = $photos[$i]->data->description;
                            $numberComments = $photos[$i]->data->numberComment;
                            $numberLikes    = $photos[$i]->data->numberLike;
                            $likeState = ($likeStatus[$photos[$i]->recordID] == 'null') ? 'Like' : 'Unlike';
                        ?>
                            <div class="pinItems">
                                <div class="photoItems">
                                    <a class="viewThisPhoto" id="<?php echo $photoID; ?>">
                                        <img src="<?php echo $photoURL; ?>">
                                    </a>
                                </div>
                                <div class="photoDescription">
                                    <span><?php echo $description; ?></span>
                                </div>
                                <div class="photoSelectOptions column-group">
                                    <nav class="ink-navigation">
                                        <ul class="menu horizontal">
                                            <!--Like Segments-->
                                            <li>
                                                <a href="">
                                                    <i id="likePhoto-<?php echo $postPhotoID;?>" class="likePhotoSegments" title="<?php echo $likeState;?>"></i>
                                                    <span class="countLike"><?php echo $numberLikes;?></span>
                                                </a>
                                                <form class="likeHidden" id="likeHiddenID-<?php echo $postPhotoID; ?>">
                                                    <input type="hidden" name="id" value="<?php echo substr($otherUserID, strpos($otherUserID, ':') + 1); ?>">
                                                    <input type="hidden" name="photoID" value="<?php echo $postPhotoID; ?>">
                                                </form>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="photoNavIcon-comment"></i>
                                                    <span class="countComment"><?php echo $numberComments;?></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <i class="photoNavIcon-share"></i>6,012
                                                    <span class="countShare"><?php //echo $numberShares;?></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="postActionWrapper photoItem-<?php echo $postPhotoID;?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $postPhotoID; ?>"">
                                    <?php
                                    if ($numberLikes > 0)
                                    {
                                        if ($likeStatus[$photos[$i]->recordID] == 'null')
                                        {
                                            ?>
                                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postPhotoID;?>">
                                                <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $numberLikes; ?></a> people like this.</span>
                                            </div>
                                        <?php
                                        }else {
                                            if ($numberLikes == 1)
                                            {
                                                ?>
                                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postPhotoID;?>">
                                                    <span><i class="statusCounterIcon-like"></i>You like this</span>
                                                </div>
                                            <?php
                                            }else {
                                                ?>
                                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postPhotoID;?>">
                                                    <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $numberLikes - 1; ?></a> people like this</span>
                                                </div>
                                            <?php
                                            }
                                        }
                                    }?>
                                    <?php
                                    if ($numberComments > 2)
                                    {
                                    ?>
                                        <div class="whoCommentThisPhoto verGapBox" id="<?php echo $postPhotoID;?>">
                                            <span><i class="statusCounterIcon-comment"></i><a class="viewAll" href="">View all <?php echo $numberComments;?> comments</a></span>
                                            <span class="numberComments"><?php echo $numberComments;?></span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    $records = $comments[$photos[$i]->recordID];
                                    if (!empty($records))
                                    {
                                    ?>
                                    <div class="commentContentWrapper">
                                        <?php
                                        $pos = (count($records) < 2 ? count($records) : 2);
                                        for($j = $pos - 1; $j >= 0; $j--)
                                        {
                                            $user   = $commentActor[$comments[$photos[$i]->recordID][$j]->data->actor];
                                            $actorComment = $comments[$photos[$i]->recordID][$j]->data->actor_name;
                                            $content= $comments[$photos[$i]->recordID][$j]->data->content;
                                            $published  = $comments[$photos[$i]->recordID][$j]->data->published;
                                            ?>
                                            <div class="eachCommentItem verGapBox column-group">
                                                <div class="large-20 uiActorCommentPicCol">
                                                    <a href="/content/myPost?username=<?php echo $user->data->username; ?>">
                                                        <img src="<?php echo $user->data->profilePic; ?>">
                                                    </a>
                                                </div>
                                                <div class="large-80 uiCommentContent">
                                                    <p>
                                                        <a class="timeLineCommentLink" href="/content/myPost?username=<?php echo $user->data->username; ?>"><?php echo $actorComment; ?></a>
                                                        <span class="textComment"><?php echo $content; ?></span>
                                                    </p>
                                                    <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
                                                </div>
                                            </div>
                                        <?php
                                        } // end for
                                        ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $postPhotoID?>">
                                        <div class="large-20 uiActorCommentPicCol">
                                            <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                                        </div>
                                        <div class="large-80 uiTextCommentArea">
                                            <form class="ink-form" id="fmPhotoComment-<?php echo $postPhotoID; ?>">
                                                <fieldset>
                                                    <div class="control-group">
                                                        <div class="control">
                                                            <input name="postPhotoID" type="hidden" value="<?php echo $postPhotoID?>" />
                                                            <textarea name="comment" class="taPostComment postComment" id="photoComment-<?php echo $postPhotoID; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
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
<div id="fadePhoto" class="black_overlay"></div>
<div class="uiLightUpload uiPopUp">
    <div class="containerPhotoPopUp">
        <div class="actionUpload">
            <input name="album_id" id="albumID" value="none" type="hidden">
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
<div class="uiCreateAlbum uiPopUp">
    <div class="uiContainerPopUp">
        <div class="titlePopUp large-100">
            <span>Create Album</span>
        </div>
        <div class="mainPopUp large-100">
            <div class="uiAlbumContainer large-100">
                <form class="ink-form" id="albumInfo">
                    <fieldset>
                        <div class="control-group">
                            <label for="name">Album Name</label>
                            <div class="control">
                                <input type="text" name="titleAlbum" class="titleAlbum" autocomplete="off" placeholder="Untitled Album...">
                            </div>
                        </div>
                        <div class="uiAlbumAlerts"></div>
                        <div class="control-group">
                            <label for="name">Description</label>
                            <div class="control">
                                <textarea name="descriptionAlbum" class="taDescriptionAlbum" spellcheck="false" placeholder="Write description for this album..."></textarea>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="actionPopUp column-group push-right large-100">
            <a class="uiMediumButton blue createAlbumButton">Create</a>
            <a class="uiMediumButton white closeLightBox">Cancel</a>
        </div>
    </div>
</div>
<div id="uiPhotoView" class="uiPopUp"></div>
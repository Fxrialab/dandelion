
<?php
$currentUser= $this->f3->get('currentUser');
$albumID    = $this->f3->get('albumID');
$photos     = $this->f3->get("photos");
$comments   = $this->f3->get('comments');
$commentActor   = $this->f3->get('commentActor');
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
                            $postPhotoID = str_replace(':', '_',$photos[$i]->recordID);
                            $photoURL= $photos[$i]->data->url;
                            $description = $photos[$i]->data->description;
                            $numberComments = $photos[$i]->data->numberComment;
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
                                            <li><a href=""><i class="photoNavIcon-like"></i>23</a></li>
                                            <li><a href=""><i class="photoNavIcon-comment"></i> 54</a></li>
                                            <li><a href=""><i class="photoNavIcon-share"></i> 5</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="postActionWrapper uiBox-PopUp boxLikeTopLeftArrow photoItem-<?php echo $postPhotoID;?>">
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
            <input name="album_id" id="albumID" value="<?php echo $albumID; ?>" type="hidden">
            <div id="multiFiles">Select Files</div>
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
<div id="uiPhotoView" class="uiPopUp"></div>
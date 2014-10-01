<?php
$photosJson         = $this->f3->get("photosJson");
$numberPhotos       = $this->f3->get('numberPhoto');
$album_id           = $this->f3->get("album_id");

$urlsJson           = $this->f3->get("urlsJson");
$comments           = $this->f3->get("commentsOfPhoto");
$commentActor       = $this->f3->get("commentActor");
$photos             = $this->f3->get("photos");
//$itemPhoto           = F3::get("itemPhoto");
$key                = $this->f3->get('key');
$infoActorPhotoUser = $this->f3->get('infoActorPhotoUser');
$currentUser        = $this->f3->get('currentUser');
$likeStatus         = $this->f3->get('likeStatus');
$statusFollow       = $this->f3->get('statusFollow');
?>
<script type="text/javascript">
    var photos      = <?php echo $photosJson ?>;
    var urls        = <?php echo $urlsJson ?>;
    var photoIndex  = <?php echo $key ?>;//@todo vi tri thu may trong bang photo
    var countPhotos = photos.length;
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
            $(".containerPhoto").preload(urls, photos);
        }
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
    <div class="leftColPopUp">
        <div class="containerPhoto">

        </div>
        <div class="uiPreviousArrow">
            <a href="" class="uiMediumButton previousBtn" title="Previous"><i class="leftArrowPopUp"></i></a>
        </div>
        <div class="uiNextArrow">
            <a href="" class="uiMediumButton nextBtn" title="Next"><i class="rightArrowPopUp"></i></a>
        </div>
    </div>
    <div class="rightColPopUp">
        <div class="large-100">
            <a class="uiClosePhotoPopUp" title="close"><i class="chatIcons-close"></i></a>
        </div>
        <?php
        if($photos )
        {
            for($i=0; $i < count($photos); $i ++)
            {
                $description = $photos[$i]->data->description;
                $numberComments = $photos[$i]->data->numberComment;
                $numberLikes = $photos[$i]->data->numberLike;
                $publishedPost =  $photos[$i]->data->published;
                $likeState = ($likeStatus[$photos[$i]->recordID] == 'null') ? 'Like' : 'Unlike';
                $photoID     = str_replace(':', '_', $photos[$i]->recordID);
                $actorPhotoName = ucfirst($infoActorPhotoUser[$photos[$i]->data->actor]->data->firstName)." ".ucfirst($infoActorPhotoUser[$photos[$i]->data->actor]->data->lastName);
                $profilePicActorPhoto = $infoActorPhotoUser[$photos[$i]->data->actor]->data->profilePic;
            //echo $profilePicActorPhoto;
            ?>
            <div id="contentPhotoItem<?php echo $photoID; ?>" class="invisiblePhotoWrap">
                <div class="viewPhotoInfo column-group">
                    <div class="large-30 uiActorPicCol">
                        <a href=""><img src="<?php echo $profilePicActorPhoto; ?>" /></a>
                    </div>
                    <div class="large-70 actorNamePhotoInfo">
                        <div class="articleActorName fixMarginBottom-5">
                            <a href="" class="timeLineLink"><?php echo $actorPhotoName;?></a>
                        </div>
                        <span><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $publishedPost; ?>"></a></span>
                    </div>
                    <div class="large-100 photoDescription">
                        <span class="textPost"><?php echo $description;?></span>
                    </div>
                </div>
                <div class="photoSelectOptions column-group">
                    <nav class="ink-navigation">
                        <ul class="menu horizontal">

                            <li>
                                <a href="">
                                    <i id="likePhoto-<?php echo $photoID;?>" class="likePhotoSegments" title="<?php echo $likeState;?>"></i>
                                    <span class="countLike"><?php echo $numberLikes;?></span>
                                </a>
                                <form class="likeHidden" id="likeHiddenID-<?php echo $photoID; ?>">
                                    <input type="hidden" name="id" value="<?php //echo substr($otherUserID, strpos($otherUserID, ':') + 1); ?>">
                                    <input type="hidden" name="photoID" value="<?php echo $photoID; ?>">
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
                <div class="postActionWrapper photoItem-<?php echo $photoID;?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $photoID; ?>">
                <?php
                if ($numberLikes > 0)
                {
                    if ($likeStatus[$photos[$i]->recordID] == 'null')
                    {
                        ?>
                        <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $photoID;?>">
                            <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $numberLikes; ?></a> people like this.</span>
                        </div>
                    <?php
                    }else {
                        if ($numberLikes == 1)
                        {
                            ?>
                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $photoID;?>">
                                <span><i class="statusCounterIcon-like"></i>You like this</span>
                            </div>
                        <?php
                        }else {
                            ?>
                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $photoID;?>">
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
                    <div class="whoCommentThisPhoto verGapBox" id="<?php echo $photoID;?>">
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
                            $actorComment = ucfirst($user->data->firstName).' '.ucfirst($user->data->lastName);
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
                    <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $photoID?>">
                        <div class="large-20 uiActorCommentPicCol">
                            <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
                        </div>
                        <div class="large-80 uiTextCommentArea">
                            <form class="ink-form" id="fmPhotoComment-<?php echo $photoID; ?>">
                                <fieldset>
                                    <div class="control-group">
                                        <div class="control">
                                            <input name="postPhotoID" type="hidden" value="<?php echo $photoID?>" />
                                            <textarea name="comment" class="taPostComment postComment" id="photoComment-<?php echo $photoID; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
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

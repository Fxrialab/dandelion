
<!--                            <div class="photoDescription">
                                <span><?php // echo $description; ?></span>
                            </div>-->
<!--                            <div class="photoSelectOptions column-group">
                                <nav class="ink-navigation">
                                    <ul class="menu horizontal">
                                        Like Segments
                                        <li>
                                            <a href="">
                                                <i id="likePhoto-<?php echo $postPhotoID; ?>" class="likePhotoSegments" title="<?php echo $likeState; ?>"></i>
                                                <span class="countLike"><?php echo $numberLikes; ?></span>
                                            </a>
                                            <form class="likeHidden" id="likeHiddenID-<?php echo $postPhotoID; ?>">
                                                <input type="hidden" name="id" value="<?php // echo substr($otherUserID, strpos($otherUserID, ':') + 1);     ?>">
                                                <input type="hidden" name="photoID" value="<?php echo $postPhotoID; ?>">
                                            </form>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="photoNavIcon-comment"></i>
                                                <span class="countComment"><?php echo $numberComments; ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="photoNavIcon-share"></i>6,012
                                                <span class="countShare"><?php //echo $numberShares;              ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>-->
<!--                            <div class="postActionWrapper photoItem-<?php echo $postPhotoID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $postPhotoID; ?>"">
                                <?php
                                if ($numberLikes > 0)
                                {
                                    if ($likeStatus[$photos[$i]->recordID] == 'null')
                                    {
                                        ?>
                                        <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postPhotoID; ?>">
                                            <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $numberLikes; ?></a> people like this.</span>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        if ($numberLikes == 1)
                                        {
                                            ?>
                                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postPhotoID; ?>">
                                                <span><i class="statusCounterIcon-like"></i>You like this</span>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $postPhotoID; ?>">
                                                <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $numberLikes - 1; ?></a> people like this</span>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <?php
                                if ($numberComments > 2)
                                {
                                    ?>
                                    <div class="whoCommentThisPhoto verGapBox" id="<?php echo $postPhotoID; ?>">
                                        <span><i class="statusCounterIcon-comment"></i><a class="viewAll" href="">View all <?php echo $numberComments; ?> comments</a></span>
                                        <span class="numberComments"><?php echo $numberComments; ?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php
//                                    $records = $comments[$photos[$i]->recordID];
                                if (!empty($records))
                                {
                                    ?>
                                    <div class="commentContentWrapper">
                                        <?php
                                        $pos = (count($records) < 2 ? count($records) : 2);
                                        for ($j = $pos - 1; $j >= 0; $j--)
                                        {
                                            $user = $commentActor[$comments[$photos[$i]->recordID][$j]->data->actor];
                                            $actorComment = $comments[$photos[$i]->recordID][$j]->data->actor_name;
                                            $content = $comments[$photos[$i]->recordID][$j]->data->content;
                                            $published = $comments[$photos[$i]->recordID][$j]->data->published;
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
                                <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $postPhotoID ?>">
                                    <div class="large-20 uiActorCommentPicCol">
                                        <a href=""><img src="<?php // echo $currentUser->data->profilePic;     ?>"></a>
                                    </div>
                                    <div class="large-80 uiTextCommentArea">
                                        <form class="ink-form" id="fmPhotoComment-<?php echo $postPhotoID; ?>">
                                            <fieldset>
                                                <div class="control-group">
                                                    <div class="control">
                                                        <input name="postPhotoID" type="hidden" value="<?php echo $postPhotoID ?>" />
                                                        <textarea name="comment" class="taPostComment postComment" id="photoComment-<?php echo $postPhotoID; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>-->

<div id="fade" class="black_overlay"></div>
<div id="fadePhoto" class="black_overlay"></div>
<div class="uiLightUpload uiPopUp">
    <div class="containerPhotoPopUp">
        <div class="actionUpload">
            <input name="album_id" id="albumID" value="none" type="hidden">
            <div id="singleFile">Select Files</div>
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
<div class="dialogComment"></div>
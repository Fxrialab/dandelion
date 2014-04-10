
<div class="uiBoxPostItem">
    <div class="uiBoxPostContainer column-group">
        <div class="large-10 uiActorPicCol">
            <a href="/content/myPost?username=<?php echo $username ?>"><img src="<?php echo $avatar ?>"></a>
        </div>
        <div class="large-85 uiPostContent">
            <div class="articleActorName fixMarginBottom-5">
                <a href="/content/myPost?username=<?php echo $username ?>" class="timeLineLink"><?php echo $status->data->actorName; ?></a>
            </div>
            <div class="articleContentWrapper">
                <div class="column-group">
                    <?php
                    if (!empty($status->data->img)) {
                        $img = explode(',', $status->data->img);
                        $countImg = count($img);
                        foreach ($img as $value) {
                            $findImg = PostController::getPhoto($value);
                            if ($countImg == 1) {
                                echo '<div class="large-100"><img src=' . $findImg->data->url . '></div>';
                            } elseif ($countImg == 3) {
                                echo '<div class="large-30"><div class="imgPost"><img src=' . $findImg->data->url . '></div></div>';
                            } else {
                                echo '<div class="large-50"><div class="imgPost"><img src=' . $findImg->data->url . '></div></div>';
                            }
                        }
                    }
                    ?>
                </div>
                <div class="textPostContainer fixMarginBottom-5">
                    <span class="textPost"><?php echo $status->data->content; ?></span>
                </div>

            </div>
            <div class="articleSelectOption">
                <div class="articleActions">
                    <nav class="ink-navigation">
                        <ul class="menu horizontal">
                            <!--Like Segments-->
                            <li class="like-<?php echo $rpStatusID ?>">
                                <?php
                                if ($like == TRUE) {
                                    ?>
                                    <a href="javascript:void(0)" onclick="unlike('<?php echo $rpStatusID ?>', '<?php echo $status->data->actor ?>')" title="Like post">Un Like</a>
                                <?php } else { ?>
                                    <a href="javascript:void(0)" onclick="like('<?php echo $rpStatusID ?>', '<?php echo $status->data->actor ?>')" title="Like post">Like</a>
                                <?php } ?>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <!--Comment Segments-->
                            <li>
                                <a href="#" class="commentBtn" id="stream-<?php echo $rpStatusID; ?>" title="Comment to post">Comment</a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <?php
                            if ($status->data->contentShare == 'none') {
                                ?>
                                <!--Share Segments-->
                                <li ><a class="shareStatus" onclick="ShareStatus('<?php echo str_replace(":", "_", $statusID); ?>')" title="Share">Share</a></li>
                                <li class="gapArticleActions">.</li>
                                <?php
                            } else {
                                ?>
                                <!--Share Segments-->
                                <li ><a class="shareStatus" onclick="ShareStatus('<?php echo str_replace(":", "_", $status->data->mainStatus); ?>')" title="Share">Share</a></li>
                                <li class="gapArticleActions">.</li>
                                <?php
                            }
                            ?>

                            <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $status->data->published; ?>"></a></li>
                            <!----article post counter---->
                            <li class="rightFix">
                                <span>
                                    <a href="#" class="likeCounter gapArticleActions" title="Like"><i class="statusCounterIcon-like"></i><span id="numLike-<?php echo $rpStatusID; ?>"><?php echo $status->data->numberLike ?></span></a>
                                    <a href="#" class="commentCounter gapArticleActions" title="Comment"><i class="statusCounterIcon-comment"></i><span id="numC-<?php echo $rpStatusID; ?>"><?php echo $status->data->numberComment ?></span></a>
                                    <a href="#" class="shareCounter gapArticleActions" title="Share"><i class="statusCounterIcon-share"></i><span id="numS-<?php echo $rpStatusID; ?>"><?php echo $status->data->numberShared ?></span></a>

                                </span>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="postActionWrapper postItem-<?php echo $rpStatusID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $rpStatusID; ?>">
                    <?php
//                    $records = $mod['comment'][$statusID];
                    if ($status->data->numberLike > 0) {
                        if ($status->data->numberLike == 'null') {
                            ?>
                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $status->data->numberLike; ?></a> people like this.</span>
                            </div>
                            <?php
                        } else {
                            if ($status->data->numberLike == 1) {
                                ?>
                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                    <span><i class="statusCounterIcon-like"></i>You like this</span>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                    <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $status->data->numberLike - 1; ?></a> people like this</span>
                                </div>
                                <?php
                            }
                        }
                    }
                    if ($activity->numberComment > 3) {
                        ?>
                        <div class="whoCommentThisPost verGapBox">
                            <span><i class="statusCounterIcon-comment"></i><a class="viewAll" href ="javascript:void(0)" onclick="moreComment('<?php echo $rpStatusID; ?>')">View all <?php echo $activity->numberComment; ?> comments</a></span>
                            <span class="numberComments"><?php echo $activity->numberComment; ?></span>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="commentContentWrapper moreComment-<?php echo $rpStatusID ?>">
                        <?php
                        $f3 = require('viewComment.php');
                        ?>
                    </div>

                    <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $rpStatusID ?>">
                        <div class="large-10 uiActorCommentPicCol">
                            <a href="/content/myPost?username=<?php echo $username ?>"><img src="<?php echo $avatar ?>"></a>
                        </div>
                        <div class="large-90 uiTextCommentArea">
                            <form class="ink-form" id="fmComment-<?php echo $rpStatusID ?>">
                                <fieldset>
                                    <div class="control-group">
                                        <div class="control">
                                            <input name="postID" type="hidden" value="<?php echo $rpStatusID ?>" />
                                            <textarea name="comment" class="taPostComment submitComment" id="textComment-<?php echo $rpStatusID ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-5 uiPostOption">
            <a href="" class="postOption" data-action=".optionPopUp"><i class="optionIcon-articlePost"></i></a>
            <div class="uiPostOptionPopUpOver uiBox-PopUp topRightArrow" data-target=".optionPopUp">
                <nav class="ink-navigation">
                    <ul class="menu vertical">
                        <li><a class="test" href="#">Report this post</a></li>
                        <li><a href="#">Option 1</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
                                    $(function() {
                                        $(".submitComment").bind('keypress', function(e) {
                                            var code = e.keyCode || e.which;
                                            if (code == 13)
                                            {
                                                var statusID = $(this).attr('id').replace('textComment-', '');
                                                var comment = $("#textComment-" + statusID).val();
                                                var numComment = parseInt($("#numCommentValue-" + statusID).val());
                                                console.log('cm: ', comment);
                                                if (comment == '')
                                                {
                                                    return false;
                                                } else {
                                                    var url, urlString, urlSpace, urlHttp, urlFirst, fullURL;
                                                    var text = $('#textComment-' + statusID).val();
                                                    text = $('<span>' + text + '</span>').text(); //strip html
                                                    urlHttp = text.indexOf('http');
                                                    if (urlHttp >= 0)
                                                    {
                                                        urlString = text.substr(urlHttp);
                                                        urlSpace = urlString.indexOf(" ");
                                                        if (urlSpace >= 0)
                                                        {
                                                            urlFirst = text.substr(urlHttp, urlSpace);
                                                            if (isValidURL(urlFirst))
                                                            {
                                                                fullURL = url = urlFirst;
                                                            }
                                                        } else {
                                                            if (isValidURL(urlString))
                                                            {
                                                                fullURL = url = urlString;
                                                            }
                                                        }
                                                    }
                                                    $('#fmComment-' + statusID).append("<input id='fullURL' name='fullURL' type='hidden' value=" + fullURL + ">");
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "/content/post/postComment",
                                                        data: $('#fmComment-' + statusID).serialize(),
                                                        cache: false,
                                                        success: function(html) {
                                                            $("#numC-" + statusID).html(numComment + 1);
                                                            $("#commentBox-" + statusID).before(html);
                                                            $("#textComment-" + statusID).val('');
                                                        }
                                                    });
                                                    exit();
                                                }
                                            }
                                            //return false;
                                        });
                                    });
                                    /**
                                     * Comment
                                     */

</script>
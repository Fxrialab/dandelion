
<?php
$currentProfile = $this->f3->get('SESSION.loggedUser');
$rpOwnerID = str_replace(':', '_', $status->data->owner);
$rpStatusID = str_replace(":", "_", $status->recordID);
$embedType = $status->data->embedType;
$status_content = $status->data->content;
$numberLikes = $status->data->numberLike;
$numberComment = $status->data->numberComment;
$status_contentShare = $status->data->contentShare;
$status_published = $status->data->published;
?>

<div class="uiBoxPostItem postItem-<?php echo $rpStatusID; ?>">
    <div class="uiBoxPostContainer column-group">
        <div class="large-10 uiActorPicCol">
            <a href="/user/<?php echo $username ?>"><img src="<?php echo $this->getAvatar($profilePic) ?>"></a>
        </div>
        <div class="large-85">
            <div class="postContent">
                <a href="/user/<?php echo $username ?>" class="timeLineLink"><?php
                    echo $actorName;
                    ?></a> 
                <?php
                if (!empty($p) && $p == 'home' && $status->data->type == 'group')
                {
                    $group = HelperController::findGroup($status->data->typeID);
                    echo " - <a class='timeLineLink' href='/content/group/groupdetail?id=" . str_replace(':', '_', $group->recordID) . "'>" . $group->data->name . '</a>';
                }
                ?>
                <div class="column-group">
                    <?php
                    if ($status_contentShare == 'none')
                    {
                        $existLink = strpos($status_content, "http");
                        if (!empty($status->data->embedType) && $status->data->embedType == 'none' || $status->data->embedType == 'photo')
                        {
                            if (is_bool($existLink))
                            {
                                ?>
                                <div class="textPostContainer">
                                    <span class="textPost"><?php echo $status_content; ?></span>
                                </div>
                                <?php
                            }
                            else
                            {
                                $existSpace = strpos(substr($status_content, $existLink), ' ');
                                $link = !empty($existSpace) ? substr($status_content, $existLink, $existSpace) : substr($status_content, $existLink);
                                $htmlLink = "<a href='" . $link . "'>" . $link . "</a>";
                                ?>
                                <div class="textPostContainer ">
                                    <span class="textPost"><?php echo str_replace($link, $htmlLink, $status_content); ?></span>
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <div class="textPostContainer">
                                <span class="textPost">
                                    <?php
                                    if (!is_bool($existLink))
                                    {
                                        $existSpace = strpos(substr($status_content, $existLink), ' ');
                                        $link = !empty($existSpace) ? substr($status_content, $existLink, $existSpace) : substr($status_content, $existLink);
                                        $htmlLink = "<a href='" . $link . "'>" . $link . "</a>";
                                        $rpLink = str_replace($link, $htmlLink, $status_content);
                                        $linkEmbed = "<a href='" . $status->data->embedSource . "'>" . $status->data->embedSource . "</a>";
                                        echo str_replace('_linkWith_', $linkEmbed, $rpLink);
                                    }
                                    else
                                    {
                                        $link = '<a href="' . $status->data->embedSource . '">' . $status->data->embedSource . '</a>';
                                        echo str_replace('_linkWith_', $link, $status_content);
                                    }
                                    ?>
                                    <a href="<?php echo $status->data->embedSource; ?>" class="oembed<?php echo $rand; ?>"></a>
                                </span>
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <div class="textPostContainer">
                            <span class="textPost"><?php echo $status_contentShare; ?></span>
                            <div class="attachmentStatus">
                                <span class="textPost"><?php echo $status_content; ?></span>
                            </div>
                        </div>
                    <?php }
                    ?>

                    <?php
                    if (!empty($photo))
                    {
                        foreach ($photo as $k => $value)
                        {
                            $img = '<a class="popupPhoto" href="/content/photo/popupPhoto?pID=' . $value->data->owner . '_' . $status->recordID . '_' . $value->recordID . '_' . $k . '"><img style="margin: 5px 0" src=' . UPLOAD_URL . 'images/' . $value->data->fileName . '></a>';
                            if (count($photo) == 1)
                                echo '<div class="large-100">' . $img . '</div>';
                            elseif (count($photo) >= 2)
                                echo '<div class="large-50"><div class="imgPost">' . $img . '</div></div>';
                        }
                    }
                    ?>
                </div>
                <div class="articleSelectOption">
                    <nav class="ink-navigation">
                        <ul class="menu horizontal">
                            <!--Like Segments-->
                            <li>
                                <a class="uiLike like_<?php echo $rpStatusID ?>" data-like="status;<?php echo $this->f3->get('SESSION.userID') . ';' . $status->recordID ?>" data-rel="<?php echo $like ? "unlike" : "like" ?>"><?php echo $like ? "Unlike" : "Like" ?></a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <!--Comment Segments-->
                            <li>
                                <a href="#" class="commentBtn" id="stream-<?php echo $rpStatusID; ?>" title="Comment to post">Comment</a>
                            </li>
                            <li class="gapArticleActions">.</li>
                            <?php
                            if ($status->data->contentShare == 'none')
                            {
                                ?>
                                <!--Share Segments-->
                                <li ><a class="shareStatus" id="<?php echo $rpStatusID; ?>" title="Share">Share</a></li>
                                <li class="gapArticleActions">.</li>
                                <?php
                            }
                            else
                            {
                                ?>
                                <!--Share Segments-->
                                <li ><a class="shareStatus" id="<?php echo str_replace(":", "_", $status->data->mainStatus); ?>" title="Share">Share</a></li>
                                <li class="gapArticleActions">.</li>
                                <?php
                            }
                            ?>

                            <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" name="<?php echo $status->data->published; ?>"></a></li>
                            <!----article post counter---->
                            <li class="rightFix">
                                <a href="#"  title="Like"><i class="statusCounterIcon-like"></i><span class="l1_<?php echo $rpStatusID ?>"><?php echo $status->data->numberLike ?></span></a>
                                <a href="#"  title="Comment"><i class="statusCounterIcon-comment"></i><span class="c1_<?php echo $rpStatusID ?>"><?php echo $status->data->numberComment ?></span></a>
                                <a href="#"  title="Share"><i class="statusCounterIcon-share"></i><span class="s1_<?php echo $rpStatusID ?>"><?php echo $status->data->numberShared ?></span></a>
                            </li>
                        </ul>
                    </nav>
                    <div class="postItem-<?php echo $rpStatusID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $rpStatusID; ?> postItem">
                        <?php
                        if ($status->data->numberLike > 0)
                        {
                            if (!empty($like))
                            {
                                ?>
                                <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                    <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $status->data->numberLike; ?></a> people like this.</span>
                                </div>
                                <?php
                            }
                            else
                            {
                                if ($status->data->numberLike == 1)
                                {
                                    ?>
                                    <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                        <span><i class="statusCounterIcon-like"></i>You like this</span>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                        <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $status->data->numberLike - 1; ?></a> people like this</span>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        if ($status->data->numberComment > 3)
                        {
                            ?>
                            <div class="whoCommentThisPost verGapBox" id="viewComments-<?php echo $rpStatusID; ?>">
                                <i class="statusCounterIcon-comment"></i><a class="viewAllComments" id="<?php echo $rpStatusID; ?>">View all <?php echo $status->data->numberComment; ?> comments <span style="width: 10px" class="loading_<?php echo $rpStatusID; ?>"><div class='loading2'></div></span></a>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="moreComment_<?php echo $rpStatusID; ?>">
                            <?php
                            if (!empty($mod['comment']))
                                $f3 = require('viewComment.php');
                            ?>
                        </div>
                        <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $rpStatusID; ?>">
                            <div class="large-10 uiActorCommentPicCol">
                                <a href="/user/<?php echo $currentProfile->data->username; ?>"><img src="<?php echo $this->getAvatar($currentProfile->data->profilePic) ?>"></a>
                            </div>
                            <div class="large-90 uiTextCommentArea">
                                <?php
                                $uni = uniqid();
                                ?>
                                <form class="ink-form" id="formcm_<?php echo $uni ?>">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="control">
                                                <input name="typeID" type="hidden" id="<?php echo $uni ?>" value="<?php echo $rpStatusID; ?>" />
                                                <textarea name="comment" class="taPostComment submitComment" id="comment_<?php echo $uni ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="large-5">
            <div style="position: relative">
                <a data-dropdown="#dropdown-<?php echo $rpStatusID; ?>"><i class="icon30-options"></i></a>
                <div id="dropdown-<?php echo $rpStatusID; ?>" class="dropdown dropdown-tip dropdown-anchor-right dropdown-right">
                    <ul class="dropdown-menu">
                        <li><a class="test" href="#">Report this post</a></li>
                        <li><a class="deleteAction" id="<?php echo $rpStatusID; ?>">Delete this post</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" charset="utf-8">
    $(function() {

    function log_modal_event(event, modal) {
    if (typeof console != 'undefined' && console.log)
    console.log("[event] " + event.type);
    }
    ;

    $(document).on($.modal.BEFORE_BLOCK, log_modal_event);
    $(document).on($.modal.BLOCK, log_modal_event);
    $(document).on($.modal.BEFORE_OPEN, log_modal_event);
    $(document).on($.modal.OPEN, log_modal_event);
    $(document).on($.modal.BEFORE_CLOSE, log_modal_event);
    $(document).on($.modal.CLOSE, log_modal_event);
    $(document).on($.modal.AJAX_SEND, log_modal_event);
    $(document).on($.modal.AJAX_SUCCESS, log_modal_event);
    $(document).on($.modal.AJAX_COMPLETE, log_modal_event);


    $('.popup').click(function(event) {
    event.preventDefault();
    $.get(this.href, function(html) {
    $(html).appendTo('body').modal();
    });
    });



    });
</script>

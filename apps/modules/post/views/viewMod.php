
<?php
$currentProfile = $this->f3->get('SESSION.loggedUser');
$rpOwnerID = str_replace(':', '_', $status->data->owner);
$rpStatusID = str_replace(":", "_", $status->recordID);
$embedType = $status->data->embedType;
$status_content = $status->data->content;
$numberLikes = $status->data->numberLike;
$numberComment = $status->data->numberComment;
$status_contentShare = $status->data->contentShare;
?>

<div class="uiBoxPostItem postItem-<?php echo $rpStatusID; ?>">
    <div class="uiBoxPostContainer">
        <div style="padding:10px">
            <div class="column-group">
                <div class="large-10 uiActorPicCol">
                    <a href="/user/<?php echo $username ?>"><img src="<?php echo $this->getAvatar($profilePic) ?>"></a>
                </div>
                <div class=" large-85">
                    <a href="/user/<?php echo $username ?>" class="timeLineLink"><?php echo $actorName ?></a> 

                    <?php
                    if ($status->data->embedType == 'photo')
                    {
                        $param = explode(',', $status->data->param);
                    } else if ($status->data->contentShare != 'none')
                    {

                        $param = explode(',', $status->data->param);
                        echo ' shared <a href="/user/' . $this->getUsername($param[0]) . '">' . $param[1] . '</a>';
                    } else
                    {
                        if ($status->data->param != 'none')
                        {
                            $param = explode(',', $status->data->param);
                            echo ' <i class="fa fa-caret-right"></i> <a href="/content/group/groupdetail?id=' . $this->getId($param[0]) . '" class="timeLineLink">' . $param[1] . '</a>';
                        }
                    }
                    ?>
                    <div class="streamPostTime">
                        <?php
                        echo $this->getTime($status->data->published);
                        ?>
                    </div>

                </div>
                <div class="large-5" style="text-align: right">
                    <div style="position: relative">
                        <a data-dropdown="#dropdown-<?php echo $rpStatusID; ?>"><i class="fa fa-chevron-down fa-chevron-down-color"></i></a>
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
        <?php
        if ($status->data->contentShare != 'none')
        {
            ?>
            <div class="column-group">
                <div style="padding:10px">
                    <?php echo $status->data->contentShare ?>
                </div>
            </div>

            <?php
        }
        ?>
        <?php
        if (!empty($status->data->content))
        {
            ?>
            <div class="column-group">
                <div class="<?php echo $status->data->contentShare != 'none' ? 'contentShare' : 'content' ?>">
                    <?php echo $status->data->content ?>
                </div>
            </div>

            <?php
        }
        ?>

        <?php
        if (!empty($photo))
        {
            echo '<div style="padding:0 10px;"><div class="column-group">';
            foreach ($photo as $k => $value)
            {
                $img = '<a class="popupPhoto" href="/content/photo/index?uid=' . $this->getId($value->data->owner) . '&sid=' . $this->getId($status->recordID) . '&pid=' . $this->getId($value->recordID) . '&page=' . $k . '"><img src=' . UPLOAD_URL . 'images/' . $value->data->fileName . '></a>';
                if (count($photo) == 1)
                    echo '<div class="large-100 img">' . $img . '</div>';
                elseif (count($photo) >= 2)
                    echo '<div class="large-50 img"><div class="imgPost">' . $img . '</div></div>';
            }
            echo '   </div></div>';
        }
        ?>

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
                        <li><a class="share_action_link" href="/content/post/share?id=<?php echo $rpStatusID; ?>" title="Share This Status">Share</a></li>
                        <?php
                    } else
                    {
                        ?>
                        <!--Share Segments-->
                        <li><a class="share_action_link" id="<?php echo str_replace(":", "_", $status->data->mainStatus); ?>" title="Share This Status">Share</a></li>
                        <?php
                    }
                    ?>
                    <!----article post counter---->
                    <li class="rightFix">
                        <a href="#"  title="Like"><i class="fa fa-hand-o-right"></i> <span class="l1_<?php echo $rpStatusID ?>"><?php echo $status->data->numberLike ?></span></a>
                        <a href="#"  title="Comment"><i class="fa fa-comment-o"></i> <span class="c1_<?php echo $rpStatusID ?>"><?php echo $status->data->numberComment ?></span></a>
                        <a href="#"  title="Share"><i class="fa fa-mail-forward"></i> <span class="s1_<?php echo $rpStatusID ?>"><?php echo $status->data->numberShared ?></span></a>
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
                            <span><a href="#"><i class="fa fa-hand-o-right fa-14"></i></a> <a href=""><?php echo $status->data->numberLike; ?></a> people like this.</span>
                        </div>
                        <?php
                    } else
                    {
                        if ($status->data->numberLike == 1)
                        {
                            ?>
                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                <span><i class="fa fa-hand-o-right"></i>You like this</span>
                            </div>
                            <?php
                        } else
                        {
                            ?>
                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $rpStatusID; ?>">
                                <span><i class="fa fa-hand-o-right"></i> You and <a href=""><?php echo $status->data->numberLike - 1; ?></a> people like this</span>
                            </div>
                            <?php
                        }
                    }
                }
                if ($status->data->numberComment > 3)
                {
                    ?>
                    <div class="whoCommentThisPost verGapBox" id="viewComments-<?php echo $rpStatusID; ?>">
                        <a class="pagerLink" id="<?php echo $rpStatusID; ?>">
                            <i class="fa fa-comment-o"></i> View all <?php echo $status->data->numberComment - 3; ?> comments 

                        </a>

                    </div>
                    <?php
                }
                if (!empty($mod['comment']))
                {
                    ?>
                    <div class="moreComment_<?php echo $rpStatusID; ?>">
                        <?php
                        $f3 = require('viewComment.php');
                        ?>
                    </div>
                    <?php
                }
                ?>
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
</div>
</div>


<?php
$status = F3::get('status');
$image = F3::get('image');
$like = F3::get('like');
$user = F3::get('user');
$comment = F3::get('comment');
$rpStatusID = str_replace(':', '_', $status->recordID);
?>
<div class="uiBoxPostItem postItem-<?php echo $rpStatusID; ?> post">
    <div class="uiBoxPostContainer column-group">
        <div class="large-10 uiActorPicCol">
            <a href="/content/post?user=<?php echo $user->data->username ?>"><img src="<?php echo UPLOAD_URL . $user->data->profilePic ?>"></a>
        </div>
        <div class="large-85">
            <div class="postContent">
                <a href="/content/post?user=<?php echo $user->data->username ?>" class="timeLineLink"><?php echo $user->data->fullName ?></a>
                <div class="column-group">
                    <?php
                    if ($status->data->contentShare == 'none')
                    {
                        $existLink = strpos($status->data->content, "http");
                        if (!empty($status->data->embedType) && $status->data->embedType == 'none' || $status->data->embedType == 'photo')
                        {
                            if (is_bool($existLink))
                            {
                                ?>
                                <div class="textPostContainer">
                                    <span class="textPost"><?php echo $status->data->content; ?></span>
                                </div>
                                <?php
                            }
                            else
                            {
                                $existSpace = strpos(substr($status->data->content, $existLink), ' ');
                                $link = !empty($existSpace) ? substr($status->data->content, $existLink, $existSpace) : substr($status->data->content, $existLink);
                                $htmlLink = "<a href='" . $link . "'>" . $link . "</a>";
                                ?>
                                <div class="textPostContainer ">
                                    <span class="textPost"><?php echo str_replace($link, $htmlLink, $status->data->content); ?></span>
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
                                        $existSpace = strpos(substr($status->data->content, $existLink), ' ');
                                        $link = !empty($existSpace) ? substr($status->data->content, $existLink, $existSpace) : substr($status->data->content, $existLink);
                                        $htmlLink = "<a href='" . $link . "'>" . $link . "</a>";
                                        $rpLink = str_replace($link, $htmlLink, $status->data->content);
                                        $linkEmbed = "<a href='" . $status->data->embedSource . "'>" . $status->data->embedSource . "</a>";
                                        echo str_replace('_linkWith_', $linkEmbed, $rpLink);
                                    }
                                    else
                                    {
                                        $link = '<a href="' . $status->data->embedSource . '">' . $status->data->embedSource . '</a>';
                                        echo str_replace('_linkWith_', $link, $status->data->content);
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
                            <span class="textPost"><?php echo $status->data->contentShare; ?></span>
                            <div class="attachmentStatus">
                                <span class="textPost"><?php echo $status->data->content; ?></span>
                            </div>
                        </div>
                        <?php
                    }
                    if (!empty($image))
                    {
                        $countPhoto = count($image);
                        foreach ($image as $k => $value)
                        {
                            if ($countPhoto == 1)
                                echo '<div class="large-100"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $status->recordID) . '&id=' . str_replace(":", "_", $value['id']) . '&p=' . $k . '" rel="' . $value['width'] . '"><img style="margin: 5px 0" src=' . UPLOAD_URL . $value['fileName'] . '></a></div>';
                            elseif ($countPhoto == 3)
                                echo '<div class="large-30"><div class="imgPost"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $status->recordID) . '&id=' . str_replace(":", "_", $value['id']) . '&p=' . $k . '" rel="' . $value['width'] . '"><img style="margin: 5px 0" src=' . UPLOAD_URL . $value['fileName'] . '></a></div></div>';
                            else
                                echo '<div class="large-50"><div class="imgPost"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $status->recordID) . '&id=' . str_replace(":", "_", $value['id']) . '&p=' . $k . '" rel="' . $value['width'] . '"><img style="margin: 5px 0" src=' . UPLOAD_URL . $value['fileName'] . '></a></div></div>';
                        }
                    }
//                    if (!empty($status->data->embedType) && $status->data->embedType == 'photo')
//                    {
//                        $embedSource = explode(',', $status->data->embedSource);
//                        foreach ($array as $value)
//                        {
//                            
//                        }
//                        $photo = PostController::getFindPhoto($status->recordID);
//                        if (!empty($photo))
//                        {
//                            $countPhoto = count($photo);
//                            foreach ($photo as $k => $value)
//                            {
//                                if ($countPhoto == 1)
//                                    echo '<div class="large-100"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $status->recordID) . '&id=' . str_replace(":", "_", $value->recordID) . '&p=' . $k . '"><img style="margin: 5px 0" src=' . UPLOAD_URL . $value->data->fileName . '></a></div>';
//                                elseif ($countPhoto == 3)
//                                    echo '<div class="large-30"><div class="imgPost"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $status->recordID) . '&id=' . str_replace(":", "_", $value->recordID) . '&p=' . $k . '"><img style="margin: 5px 0" src=' . UPLOAD_URL . $value->data->fileName . '></a></div></div>';
//                                else
//                                    echo '<div class="large-50"><div class="imgPost"><a class="detailPhoto" url="/content/photo/detail?typeID=' . str_replace(":", "_", $status->recordID) . '&id=' . str_replace(":", "_", $value->recordID) . '&p=' . $k . '"><img style="margin: 5px 0" src=' . UPLOAD_URL . $value->data->fileName . '></a></div></div>';
//                            }
//                        }
//                    }
                    ?>
                </div>
                <div class="articleSelectOption">
                    <nav class="ink-navigation">
                        <ul class="menu horizontal">
                            <!--Like Segments-->
                            <li class="like-<?php echo $rpStatusID ?>">
                                <?php
                                if ($like == TRUE)
                                {
                                    ?>
                                    <a class="unlikeAction" id="<?php echo $rpStatusID; ?>" rel="status" title="Unlike">Unlike</a>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a class="likeAction" id="<?php echo $rpStatusID; ?>" rel="status" title="Like">Like</a>
                                <?php } ?>
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
                                <li ><a class="shareStatus" id="<?php echo str_replace(":", "_", $rpStatusID); ?>" title="Share">Share</a></li>
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
                    <div class="postItem-<?php echo $rpStatusID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $rpStatusID; ?> postItem">
                        <?php
                        if ($status->data->numberLike > 0)
                        {
                            if ($like == false)
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
                        <div class="commentContentWrapper moreComment-<?php echo $rpStatusID ?>">
                            <?php
                            if (!empty($comment))
                            {
                                $pos = (count($comment) < 3 ? count($comment) : 3);
                                for ($j = count($comment) - $pos; $j < count($comment); $j++)
                                {
                                    ViewHtml::render('post/commentItem', array('comment' => $comment[$j]));
                                }
                            }
                            ?>
                        </div>
                        <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $rpStatusID ?>">
                            <div class="large-10 uiActorCommentPicCol">
                                <a href="/content/post?user=<?php echo $user->data->username ?>"><img src="<?php echo UPLOAD_URL . $user->data->profilePic ?>"></a>
                            </div>
                            <div class="large-90 uiTextCommentArea">
                                <form class="ink-form" id="fmComment-<?php echo $rpStatusID ?>">
                                    <fieldset>
                                        <div class="control-group">
                                            <div class="control">
                                                <input name="postID" type="hidden" value="<?php echo $rpStatusID; ?>" />
                                                <textarea name="comment" class="taPostComment submitComment" id="textComment-<?php echo $rpStatusID; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
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
            <a data-dropdown="#dropdown-<?php echo $rpStatusID; ?>"><i class="optionIcon-articlePost"></i></a>
            <div id="dropdown-<?php echo $rpStatusID; ?>" class="dropdown dropdown-tip dropdown-anchor-right dropdown-right-option">
                <ul class="dropdown-menu">
                    <li><a class="test" href="#">Report this post</a></li>
                    <li><a class="deleteAction" id="<?php echo $rpStatusID; ?>">Delete this post</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
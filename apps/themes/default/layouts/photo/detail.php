<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$photo = F3::get('photo');
$recordID = str_replace(':', '_', $photo->recordID);
$p = F3::get('p');
$count = F3::get('count');
$photoID = substr($photo->recordID, strpos($photo->recordID, ':') + 1);
$user = PhotoController::getUser($photo->data->actor);
$like = PhotoController::like($photo->recordID);
$comment = PhotoController::getFindComment($photo->recordID);
if ($user->data->profilePic != 'none')
    $avatar = UPLOAD_URL . $user->data->profilePic;
else
    $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
?>

<div class="control-group">
    <div class="large-70" style="background-color: #000;">
        <div class="control-group">
            <div class="large-100 <?php echo $recordID ?>">
                <div class="stage">
                    <?php
                    if ($p > 0)
                    {
                        ?>
                        <a  class='page prev' url="<?php echo F3::get('prev') ?>"><i class="prevPhoto"></i></a>
                    <?php } ?>
                    <img src="<?php echo UPLOAD_URL . $photo->data->fileName; ?>">
                    <?php
                    if ($p < $count)
                    {
                        ?>
                        <a  class="page next" url="<?php echo F3::get('next') ?>"><i class="nextPhoto"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="large-30">
        <div class="fade mCustomScrollbar">
            <div class="control-group">
                <div class="large-15">
                    <img src ="<?php echo $avatar ?>">
                </div>
                <div class="large-85">
                    <div class="infoProfile">
                        <a href="/content/post?user=<?php echo $user->data->username ?>" class="timeLineLink"><?php echo $user->data->fullName; ?></a>
                        <div><a class="swTimeComment time" name="<?php echo $photo->data->published; ?>"></a></div>
                    </div>
                    <a class="closeDialog float-right">Close</a>
                </div>
            </div>
            <div class="control-group">
                <div class="large-100">
                    <div style="padding: 10px 0">
                        <?php echo $photo->data->description ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="large-100">
                    <div class="postContent" style="padding-left:0;">
                        <div class="articleSelectOption">
                            <nav class="ink-navigation">
                                <ul class="menu horizontal">
                                    <!--Like Segments-->
                                    <li class="like-<?php echo $recordID ?>">
                                        <?php
                                        if ($like == TRUE)
                                        {
                                            ?>
                                            <a class="unlikeAction" id="<?php echo $recordID; ?>" rel="photoDialog" title="Unlike">Unlike</a>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <a class="likeAction" id="<?php echo $recordID; ?>" rel="photoDialog" title="Like">Like</a>
                                        <?php } ?>
                                    </li>
                                    <li class="gapArticleActions">.</li>
                                    <!--Comment Segments-->
                                    <li>
                                        <a href="#" class="commentBtn" id="stream-<?php echo $recordID; ?>" title="Comment to post">Comment</a>
                                    </li>

                                    <li class="streamPostTime"><a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $photo->data->published; ?>"></a></li>
                                    <!----article post counter---->
                                    <li class="rightFix">
                                        <span>
                                            <a href="#" class="likeCounter gapArticleActions" title="Like"><i class="statusCounterIcon-like"></i><span id="numLike-<?php echo $recordID; ?>"><?php echo $photo->data->numberLike ?></span></a>
                                            <a href="#" class="commentCounter gapArticleActions" title="Comment"><i class="statusCounterIcon-comment"></i><span id="numC-<?php echo $recordID; ?>"><?php echo $photo->data->numberComment ?></span></a>

                                        </span>
                                    </li>
                                </ul>
                            </nav>
                            <div class="postItem-<?php echo $recordID; ?> uiBox-PopUp boxLikeTopLeftArrow tempLike-<?php echo $recordID; ?> postItem">
                                <?php
//                    $records = $mod['comment'][$statusID];
                                if ($photo->data->numberLike > 0)
                                {
                                    if ($photo->data->numberLike == 'null')
                                    {
                                        ?>
                                        <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $recordID; ?>">
                                            <span><i class="statusCounterIcon-like"></i><a href=""><?php echo $photo->data->numberLike; ?></a> people like this.</span>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        if ($photo->data->numberLike == 1)
                                        {
                                            ?>
                                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $recordID; ?>">
                                                <span><i class="statusCounterIcon-like"></i>You like this</span>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <div class="whoLikeThisPost verGapBox likeSentenceView" id="likeSentence-<?php echo $recordID; ?>">
                                                <span><i class="statusCounterIcon-like"></i>You and <a href=""><?php echo $photo->data->numberLike - 1; ?></a> people like this</span>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                                if ($photo->data->numberComment > 3)
                                {
                                    ?>
                                    <div class="whoCommentThisPost verGapBox" id="viewComments-<?php echo $recordID; ?>">
                                        <i class="statusCounterIcon-comment"></i><a class="viewAllComments" id="<?php echo $recordID; ?>">View all <?php echo $photo->data->numberComment; ?> comments <span style="width: 10px" class="loading_<?php echo $recordID; ?>"></a>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="commentContentWrapper moreComment-<?php echo $recordID ?>">
                                    <div class="mCustomScrollbar">
                                        <?php
                                        if (!empty($comment))
                                        {
                                            foreach ($comment as $k => $value)
                                            {
                                                $profile = PhotoController::getUser($value->data->userID);
                                                if ($profile->data->profilePic != 'none')
                                                    $avatarComment = UPLOAD_URL . $user->data->profilePic;
                                                else
                                                    $avatarComment = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                                                ?>

                                                <div class="eachCommentItem verGapBox column-group">
                                                    <div class="large-10 uiActorCommentPicCol">
                                                        <a href="/content/post?user=<?php echo $profile->data->username; ?>"><img src="<?php echo $avatarComment; ?>"></a>
                                                    </div>
                                                    <div class="large-85 uiCommentContent">
                                                        <p>
                                                            <a class="timeLineCommentLink" href="/content/post?user=<?php echo $profile->data->username; ?>"><?php echo $profile->data->fullName; ?></a>
                                                            <span class="textComment"><?php echo $value->data->content; ?></span>
                                                        </p>
                                                        <a class="swTimeComment" name="<?php echo $value->data->published; ?>"></a>

                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $recordID ?>">
                                    <div class="large-10 uiActorCommentPicCol">
                                        <a href="/content/post?user=<?php echo $user->data->fullName ?>"><img src="<?php echo $avatar ?>"></a>
                                    </div>
                                    <div class="large-90 uiTextCommentArea">
                                        <form class="ink-form" id="formcm_<?php echo $recordID ?>">
                                            <fieldset>
                                                <div class="control-group">
                                                    <div class="control">
                                                        <input name="photoID" type="hidden" value="<?php echo $recordID; ?>" />
                                                        <textarea name="comment" style="min-height: 30px" class="submitCommentDialog" id="textComment_<?php echo $recordID; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
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

    </div>
    <script>
        $(document).ready(function() {
            $('textarea').autosize();

        });

    </script>

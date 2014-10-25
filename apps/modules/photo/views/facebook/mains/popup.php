<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$photo = F3::get('photo');
$tID = F3::get('tID');
$idn = F3::get('idn');
$idp = F3::get('idp');
$k = F3::get('k');
$recordID = str_replace(':', '_', $photo->recordID);
$like = HelperController::like($photo->recordID);
$comment = HelperController::getFindComment($photo->recordID);
$user = HelperController::findUser($photo->data->actor);
$fullName = HelperController::getFullNameUser($photo->data->actor);
$avatar = HelperController::getAvatar($user);
//info current user
$currentUser = F3::get('currentUser');
$currentUserAvatar = HelperController::getAvatar($currentUser);
?>
<link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>modalPhoto.css" type="text/css" />

<div class="control-group">
    <div class="large-65">
        <div class="popupImg">
            <?php
            if (!empty($idp))
            {
                ?>
                <a  href="/content/photo/popupPhoto?pID=<?php echo $photo->data->actor ?>_<?php echo $tID ?>_<?php echo $idp ?>_<?php echo $k - 1 ?>" class="pev popupPhoto"><i class="icon40-pev"></i></a>
                <?php
            }
            ?>
            <div class="img">
                <img style="vertical-align: middle" src="<?php echo UPLOAD_URL . 'images/' . $photo->data->fileName; ?>">
            </div>
            <?php
            if (!empty($idn))
            {
                ?>
                <a href="/content/photo/popupPhoto?pID=<?php echo $photo->data->actor ?>_<?php echo $tID ?>_<?php echo $idn ?>_<?php echo $k + 1 ?>" class="next popupPhoto"><i class="icon40-next"></i></a>
            <?php } ?>
        </div>
    </div>
    <div class="large-35">
        <div class="popupComment">
            <a class="close" href="javascript:void(0)" onclick="$.pgwModal('close');"><i class="icon16-closepopup"></i></a>
            <div class="fade mCustomScrollbar">
                <div class="control-group">
                    <div class="large-15">
                        <img src ="<?php echo $avatar ?>" style="width: 55px; height: 55px">
                    </div>
                    <div class="large-85">
                        <div class="infoProfile">
                            <a href="/content/post?user=<?php echo $user->data->username ?>" class="timeLineLink"><?php echo $fullName; ?></a>
                            <div><a class="swTimeComment time" name="<?php echo $photo->data->published; ?>"></a></div>
                        </div>
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
                                    <div class="mCustomScrollbar">
                                        <div class="commentContentWrapper moreComment-<?php echo $recordID ?>">

                                            <?php
                                            $this->inc('mains/viewComment', 'post', array('objectID' => $photo->recordID));
                                            if (!empty($comment))
                                            {
                                                foreach ($comment as $k => $value)
                                                {
                                                    $profile = HelperController::findUser($value->data->userID);
                                                    if ($profile->data->profilePic != 'none')
                                                    {
                                                        $photo = HelperController::findPhoto($user->data->profilePic);
                                                        $avatarComment = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
                                                    }
                                                    else
                                                    {
                                                        $gender = HelperController::findGender($user->recordID);
                                                        if ($gender == 'male')
                                                            $avatarComment = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                                                        else
                                                            $avatarComment = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
                                                    }
                                                    ?>

                                                    <!--                                                    <div class="eachCommentItem verGapBox column-group">
                                                                                                            <div class="large-10 uiActorCommentPicCol">
                                                                                                                <a href="/content/post?user=<?php // echo $profile->data->username;   ?>"><img src="<?php echo $avatarComment; ?>"></a>
                                                                                                            </div>
                                                                                                            <div class="large-85 uiCommentContent">
                                                                                                                <p>
                                                                                                                    <a class="timeLineCommentLink" href="/content/post?user=<?php // echo $profile->data->username;   ?>"><?php echo $profile->data->fullName; ?></a>
                                                                                                                    <span class="textComment"><?php // echo $value->data->content;   ?></span>
                                                                                                                </p>
                                                                                                                <a class="swTimeComment" name="<?php // echo $value->data->published;   ?>"></a>
                                                    
                                                                                                            </div>
                                                                                                        </div>-->
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $recordID ?>">
                                        <div class="large-10 uiActorCommentPicCol">
                                            <a href="/content/post?user=<?php echo $currentUser->data->username; ?>"><img src="<?php echo $currentUserAvatar ?>"></a>
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
    </div>
</div>
<script>
                $(document).ready(function() {
                    $('textarea').autosize();

                });
</script>
<script id="commentPhotoTemplate1" type="text/x-jQuery-tmpl">
    <div class="eachCommentItem verGapBox column-group">
    <div class="large-10 uiActorCommentPicCol">
    <a href="/content/post?user=">  <img src="<?php echo IMAGES ?>/avatarMenDefault.png"></a>
    </div>
    <div class="large-85 uiCommentContent">
    <p>
    <a class="timeLineCommentLink" href="/content/post?user=">${name}</a>
    <span class="textComment">${content}</span>
    </p>
    <a class="swTimeComment" name="${time}"></a>
    </div>
    </div>
</script>
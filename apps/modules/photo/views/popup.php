<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$loggedUser = $this->f3->get('SESSION.loggedUser');
$photo = $this->f3->get('photo');
$tID = $this->f3->get('tID');
$idn = $this->f3->get('idn');
$idp = $this->f3->get('idp');
$k = $this->f3->get('k');
$user = $this->f3->get('user');
$like = $this->f3->get('like');
$comment = $this->f3->get('comment');
$recordID = str_replace(':', '_', $photo->recordID);
?>
<link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>modalPhoto.css" type="text/css" />

<div class="control-group">
    <div class="large-65">
        <div class="popupImg">
            <?php
            if (!empty($idp))
            {
                ?>
                <a  href="/content/photo/popupPhoto?pID=<?php echo $photo->data->owner ?>_<?php echo $tID ?>_<?php echo $idp ?>_<?php echo $k - 1 ?>" class="pev popupPhoto"><i class="icon40-pev"></i></a>
                <?php
            }
            ?>
            <div class="img">
                <img style="vertical-align: middle" src="<?php echo $this->getImg($photo->recordID) ?>">
            </div>
            <?php
            if (!empty($idn))
            {
                ?>
                <a href="/content/photo/popupPhoto?pID=<?php echo $photo->data->owner ?>_<?php echo $tID ?>_<?php echo $idn ?>_<?php echo $k + 1 ?>" class="next popupPhoto"><i class="icon40-next"></i></a>
            <?php } ?>
        </div>
    </div>
    <div class="large-35">
        <div class="popupComment">
            <a class="close" href="javascript:void(0)" onclick="$.pgwModal('close');"><i class="icon16-closepopup"></i></a>
            <div class="fade mCustomScrollbar">
                <div class="control-group">
                    <div class="large-15">
                        <img src ="<?php echo $this->getAvatar($user->data->profilePic) ?>" style="width: 55px; height: 55px">
                    </div>
                    <div class="large-85">
                        <div class="infoProfile">
                            <a href="/content/post?user=<?php echo $user->data->username ?>" class="timeLineLink"><?php echo $user->data->fullName; ?></a>
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
                                    <div class="mCustomScrollbar" style="max-height: 365px;">
                                        <ul class="commentContentWrapper viewComment_<?php echo $recordID ?>" style="list-style: none; margin: 0; padding: 0">

                                            <?php
                                            if (!empty($comment))
                                            {
                                                foreach ($comment as $k => $value)
                                                {
                                                    $commentID = str_replace(':', '_', $value['comment']->recordID);
                                                    ?>
                                                    <li class="eachCommentItem verGapBox column-group" style="margin:1px 0; padding: 5px 10px">
                                                        <div class="large-15 uiActorCommentPicCol">
                                                            <a href="/user/<?php echo $value['user']->data->username ?>">  <img style="min-width: 40px; height:40px" src="<?php echo $this->getAvatar($value['user']->data->profilePic) ?>"></a>
                                                        </div>
                                                        <div class="large-85 uiCommentContent uiComment_<?php echo $commentID ?>">
                                                            <p>
                                                                <a class="timeLineCommentLink" href="/user/<?php echo $value['user']->data->username ?>"><?php echo $value['user']->data->fullName ?></a>
                                                                <span class="textComment"> <?php echo $value['comment']->data->content ?></span>
                                                            </p>
                                                            <a class="swTimeComment" name="<?php echo $value['comment']->data->published; ?>"></a>
                                                            <a class="uiLike like_<?php echo $commentID ?>" data-like="comment;<?php echo $this->f3->get('SESSION.userID') . ';' . $value['comment']->recordID ?>" data-rel="<?php echo $value['like'] ? "unlike" : "like" ?>"><?php echo $value['like'] ? "Unlike" : "Like" ?></a>
                                                            <a href="#" class="l2_<?php echo $commentID ?>"> <?php echo $value['comment']->data->numberLike ?></a>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                    <div class="uiStreamCommentBox verGapBox column-group" id="commentBox-<?php echo $recordID ?>" style="padding: 10px;">
                                        <div class="large-15 uiActorCommentPicCol">
                                            <a href="/user/<?php echo $this->f3->get('SESSION.username') ?>">
                                                <img src="<?php echo $this->getAvatar($loggedUser->data->profilePic) ?>">
                                            </a>
                                        </div>
                                        <div class="large-85 uiTextCommentArea">
                                            <?php
                                            $uni = uniqid();
                                            $f3 = require('formComment.php');
                                            ?>
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

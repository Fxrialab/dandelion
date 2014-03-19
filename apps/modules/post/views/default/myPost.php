<?php
$listStatus = $this->f3->get('listStatus');
$comments = $this->f3->get('comments');
$numberOfComments = $this->f3->get('numberOfComments');
$currentUser = $this->f3->get('currentUser');
$otherUser = $this->f3->get('otherUser');
$likeStatus = $this->f3->get('likeStatus');
$statusFollow = $this->f3->get('statusFollow');
$statusFriendship = $this->f3->get('statusFriendShip');
$postActor = $this->f3->get('postActor');
$commentActor = $this->f3->get('commentActor');
$currentProfileID = $this->f3->get('currentProfileID');
$currentUserID = $currentUser->recordID;
$otherUserID = $otherUser->recordID;
?>
<script type="text/javascript" src="<?php echo $this->f3->get('STATIC_MOD'); ?>post/webroot/js/socialewired.post.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".oembed2").oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 768,
                    autoplay: false
                });
        $(window).scroll(function() {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                $('.uiMoreView').show();
                var published = $(".uiBoxPostItem:last .uiBoxPostContainer .uiPostContent .articleSelectOption").find('.swTimeStatus').attr("name");
                var existNoMoreStatus = $('.noMoreStatus').length;
                console.log('sss', existNoMoreStatus);
                if (existNoMoreStatus == 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "/content/post/morePostStatus",
                        data: {published: published},
                        cache: false,
                        success: function(html) {
                            $("#contentContainer").append(html);
                            $('.uiMoreView').hide();
                        }
                    });
                } else {
                    $('.uiMoreView').hide();
                }
            }
        });
    });

</script>
<div class="uiMainColProfile large-70">
    <div class="uiMainContainer">
        <?php
        if ($statusFriendship == 'friend' || $currentUserID == $otherUserID)
            AppController::elementModules('postWrap', 'post');
        ?>
        <input name="profileID" id="profileID" type="hidden" value="<?php echo $currentProfileID; ?>">
        <div class="wrapperContainer">
            <div id="contentContainer">
                <?php
                if ($listStatus) {
                    for ($i = 0; $i < count($listStatus); $i++) {
                        $statusID = $listStatus[$i]->recordID;
                        $status_owner = $listStatus[$i]->data->owner;
                        $status_actor = $listStatus[$i]->data->actor;
                        $status_contentShare = $listStatus[$i]->data->contentShare;
                        $status_username = $listStatus[$i]->data->actorName;
                        $status_tagged = $listStatus[$i]->data->tagged;
                        $status_content = $listStatus[$i]->data->content;
                        $numC = $listStatus[$i]->data->numberComment;
                        $numS = $listStatus[$i]->data->numberShared;
                        $status_contentShare = $listStatus[$i]->data->contentShare;
                        $status_published = $listStatus[$i]->data->published;
                        $numberLikes = $listStatus[$i]->data->numberLike;
                        $status_mainStatus = str_replace(":", "_", $listStatus[$i]->data->mainStatus);
                        $linkProfile = '';
                        $rpStatusID = str_replace(":", "_", $listStatus[$i]->recordID);
                        $actorProfile = $postActor[$listStatus[$i]->data->actor];
                        $avatar = $actorProfile->data->profilePic;
                        $actor = $otherUserID;
                        $records = $comments[$listStatus[$i]->recordID];
                        $userCommentProfilePic = $actorProfile->data->profilePic;
                        $f3 = require('_viewPost.php');
                    }
                }
                ?>
            </div>
            <div class="uiMoreView content-center">
                <div class="loading uiLoadingIcon"></div>
            </div>
        </div>
    </div>
</div>
<!--Other part-->
<div id="fade" class="black_overlay"></div>
<div class="uiShare uiPopUp"></div>
<div class="notificationShare uiPopUp">
    <div class="titlePopUp large-100">
        <span>Success</span>
    </div>
    <div class="mainPopUp large-100">
        <span class="successNotification">That status was shared on your timeline</span>
    </div>
</div>

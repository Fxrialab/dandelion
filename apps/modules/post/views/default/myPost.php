<?php
$listStatus = $this->f3->get('listStatus');
?>

<div class="uiMainColProfile large-70">
    <div class="uiMainContainer">
        <?php
        AppController::elementModules('postWrap', 'post');
        ?>
        <input name="profileID" id="profileID" type="hidden" value="<?php echo $this->f3->get('SESSION.userID'); ?>">
        <div class="wrapperContainer">
            <div id="contentContainer">
                <?php
                foreach ($listStatus as $key => $status) {
                    $statusID = $status->recordID;
                    $activity = $status->data;
                    $user = PostController::getUser($status->data->actor);
                    $username = $user->data->username;
                    $avatar = $user->data->profilePic;
                    $like = TRUE;
                    $f3 = require('viewPost.php');
                }
                ?>
            </div>
            <!--<div class="uiMoreView content-center">
                <div class="loading uiLoadingIcon"></div>
            </div>-->
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
<?php
$photos = $this->f3->get('photos');
$model = $this->f3->get('model');
?>
<div class="arrow_timeLineMenuNav">
    <div class="arrow_phototab"></div>
</div>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <?php
        $user = $this->f3->get('otherUser');
        $f3 = require('boxTitle.php');
        ?>
        <input type="hidden" id="userID" value="<?php echo $this->f3->get('userID') ?>">
        <input type="hidden" id="albumID" value="<?php echo $this->f3->get('albumID') ?>">
        <div class="arrow_photo"></div>
        <div class="column-group">
            <div class="photoAll" id="scrollPhoto">
                <?php
                foreach ($model as $k => $photo)
                {
                    $recordID = $photo->recordID;
                    $actor = $photo->data->actor;
                    $photoName = $photo->data->fileName;
                    $numberLike = $photo->data->numberLike;
                    $photoID = str_replace(':', '_', $recordID);
                    $comment = HelperController::getFindComment($recordID);
                    $count = HelperController::countComment($recordID);
                    $like = HelperController::like($recordID);
                    $f3 = require('photoItem.php');
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('textarea').autosize();

    });
//    $(document).ready(function() {
//        $('#scrollPhoto').scrollPhoto({
//            nop: 15, // The number of posts per scroll to be loaded
//            offset: 0, // Initial offset, begins at 0 in this case
//            error: 'No More Posts!', // When the user reaches the end this is the message that is
//            // displayed. You can change this if you want.
//            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
//            // This is mainly for usability concerns. You can alter this as you see fit
//            scroll: true // The main bit, if set to false posts will not load as the user scrolls.
//                    // but will still load if the user clicks.
//        });
//    });
</script>
<script id="commentPhotoTemplate" type="text/x-jQuery-tmpl">
    <li  class="itemC_${id}">
    <div class="avatar">
    <img src="<?php echo IMAGES ?>/avatarMenDefault.png">
    </div>
    <div class="content">
    <a href="#" class="fullName">${name}</a>
    ${content}
    <p><a class="swTimeComment" name="${time}"></a></p>
    </div>
    </li>
</script>
<script id="commentPhotoTemplate1" type="text/x-jQuery-tmpl">
    <div class="eachCommentItem verGapBox column-group">
    <div class="large-10 uiActorCommentPicCol">
    <a href="/user/">  <img src="<?php echo IMAGES ?>/avatarMenDefault.png"></a>
    </div>
    <div class="large-85 uiCommentContent">
    <p>
    <a class="timeLineCommentLink" href="/user/">${name}</a>
    <span class="textComment">${content}</span>
    </p>
    <a class="swTimeComment" name="${time}"></a>
    </div>
    </div>
</script>
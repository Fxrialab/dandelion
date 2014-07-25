<?php
$photos = F3::get('photos');
?>
<div class="arrow_timeLineMenuNav">
    <div class="arrow_phototab"></div>
</div>

<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <?php require_once 'boxTitle.php'; ?>
        <input type="hidden" id="userID" value="<?php echo F3::get('SESSION.userID') ?>">
        <input type="hidden" id="albumID" value="<?php echo F3::get('albumID') ?>">
        <div class="arrow_photo"></div>



        <div class="column-group">
            <div class="photoAll" id="scrollPhoto"></div>
        </div>
    </div>
</div>
<div id="dialog"  style="display:none;">
    <iframe id="frameDialog" style="width: 100%; height: 580px; margin: 0; padding: 0; border: none; background-color: #000; overflow-x:hidden"></iframe>
</div>
<script>
    $(document).ready(function() {

    });

    $(document).ready(function() {
        $('textarea').autosize();


    });
    $(document).ready(function() {
        $('#scrollPhoto').scrollPhoto({
            nop: 15, // The number of posts per scroll to be loaded
            offset: 0, // Initial offset, begins at 0 in this case
            error: 'No More Posts!', // When the user reaches the end this is the message that is
            // displayed. You can change this if you want.
            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
            // This is mainly for usability concerns. You can alter this as you see fit
            scroll: true // The main bit, if set to false posts will not load as the user scrolls.
                    // but will still load if the user clicks.
        });
    });
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
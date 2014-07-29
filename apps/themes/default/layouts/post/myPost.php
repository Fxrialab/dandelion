<script>
    $(document).ready(function() {
    $('#contentContainer').scrollPaginationPost({
    nop: 5, // The number of posts per scroll to be loaded
    offset: 0, // Initial offset, begins at 0 in this case
    error: 'No More Posts!', // When the user reaches the end this is the message that is
    // displayed. You can change this if you want.
    delay: 500, // When you scroll down the posts will load after a delayed amount of time.
    // This is mainly for usability concerns. You can alter this as you see fit
    scroll: true // The main bit, if set to false posts will not load as the user scrolls.
    // but will still load if the user clicks.
    });
    $('#typeActivity').html('<input type=hidden id=type name=type value=post >');
    });
</script>
<div class="arrow_timeLineMenuNav">
    <div class="arrow_timeLine"></div>
</div>

<div class="uiMainColProfile large-70">
    <div class="uiMainContainer">
        <?php
        ViewHtml::render('post/formPost');
        ?>
        <!--<input type="hidden" id="type" name="type" value="post">-->
        <input name="profileID" id="profileID" type="hidden" value="<?php echo F3::get('SESSION.userID'); ?>">
        <div class="wrapperContainer">
            <div id="contentContainer">
                <!--Loading all post on here-->
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


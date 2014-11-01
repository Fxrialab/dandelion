<?php
$photos = $this->f3->get('photo');
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
                foreach ($photos as $k => $value)
                {
                    $actor = $value['user'];
                    $photo = $value['photo'];
                    $like = $value['like'];
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
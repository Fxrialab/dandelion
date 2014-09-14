
<?php
//$album = $this->f3->get('album');
?>
<div class="arrow_timeLineMenuNav">
    <div class="arrow_phototab"></div>
</div>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <?php $f3 = require('boxTitle.php'); ?>
        <input type="hidden" id="userID" value="<?php echo $this->f3->get('userID') ?>">
        <input type="hidden" id="albumID" value="">
        <div class="arrow_album"></div>
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

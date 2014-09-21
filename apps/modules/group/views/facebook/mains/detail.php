<?php
$group  = $this->f3->get('group');
$members= $this->f3->get('member');
$countMember = $this->f3->get('countMember');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#contentContainer').scrollPaginationGroupMod({
            nop: 5, // The number of posts per scroll to be loaded
            offset: 0, // Initial offset, begins at 0 in this case
            error: 'No More Posts!', // When the user reaches the end this is the message that is
            // displayed. You can change this if you want.
            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
            // This is mainly for usability concerns. You can alter this as you see fit
            scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
                    // but will still load if the user clicks.
        });
        $('#typeActivity').html('<input type=hidden id=type name=type value=group >');
        $('#typeActivityID').html('<input type=hidden id=typeID name=typeID value=<?php echo $group->recordID ?>>');
    });
</script>
<?php $f3 = require('coverPhotoGroup.php'); ?>
<?php $f3 = require('groupBar.php'); ?>
<div class="uiMainColProfile uiMainContainer large-70">
    <?php
    FactoryUtils::elementModule('formPost','post');
    ?>
    <input type="hidden" id="type" name="type" value="group">
    <input type="hidden" id="typeID" name="typeID" value="<?php echo $group->recordID ?>">

    <div id="contentContainer">

    </div>
</div>
<div class="large-30 uiRightCol">
    <?php $f3 = require('rightColGroup.php'); ?>
</div>
<script>
    $("body").on('click', '.removeImgGroup', function(e) {
        var title = $(this).attr('title');
        $(".dialog").dialog({
            width: "500",
            height: "160",
            position: ['top', 100],
            title: title,
            resizable: true,
            modal: true,
            open: function(event, ui) {
                $(".ui-dialog-titlebar-close").hide();
                $("#alertTemplate").tmpl().appendTo(".dialog");
            }
        });
    });

</script>
<script id="alertTemplate" type="text/x-jQuery-tmpl">
    <div class="control-group">
        <div class="control">
            <div class="statusDialog">Are you sure you want to remove this cover.</div>
            <div class="footerDialog">
                <div class="float-right">
                    <button type="submit" class="ink-button green-button comfirmDialogGroup">Comfirm</button>
                    <button class=" closeDialog ink-button ">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</script>
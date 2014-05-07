<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = $this->f3->get('group');
$members = $this->f3->get('member');
?>

<!--<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js'></script>-->
<script>
    $(document).ready(function() {

        $('#contentContainer').scrollPagination({
            nop: 5, // The number of posts per scroll to be loaded
            offset: 0, // Initial offset, begins at 0 in this case
            error: 'No More Posts!', // When the user reaches the end this is the message that is
            // displayed. You can change this if you want.
            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
            // This is mainly for usability concerns. You can alter this as you see fit
            scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
                    // but will still load if the user clicks.

        });

    });
    $(document).ready(function() {
        $('#typeActivity').html('<input type=hidden id=type name=type value=group >');
        $('#typeActivityID').html('<input type=hidden id=typeID name=typeID value=<?php echo $group->recordID ?>>');
    })
    $(document).ready(function() {
        $("#myPhotoGroup").click(function() {
            var title = $(this).attr('title');
            var id = $(this).attr('rel');
            $("#dialog").dialog({
                width: "700",
                height: "400",
                position: ['top', 100],
                title: title,
                resizable: false,
                modal: true,
                open: function(event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $('body').css('overflow', 'hidden'); //this line does the actual hiding
                    $('#dialog').html('<p class="loading">Loading...</p>');
                }
            });

            $.ajax({
                type: "POST",
                url: "/content/group/myphotos",
                data: {id: id},
                success: function(data) {
                    $("#dialog").html(data);

                }
            });
        });
    });
    $("body").on('click', '.closeDialog', function(e) {
        // prevent the default action, e.g., following a link
        e.preventDefault();
        $("#dialog").dialog("close");
        $('body').css('overflow', 'scroll'); //this line does the actual hiding
    });
    $("body").on('click', '.choosePhoto', function(e) {
        e.preventDefault();
        var photoID = $(this).attr('rel');
        var groupID = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: "/content/group/cover",
            data: {groupID: groupID, photoID: photoID},
            success: function(data) {
                $("#displayPhotoGroup").html(data);
                $("#dialog").dialog("close");
                $('body').css('overflow', 'scroll');
            }
        });
    });
</script>

<div class="large-100">

    <div class="column-group" id="displayPhotoGroup">
        <?php
        if (!empty($group->data->urlCover))
        {
            $urlCover = $group->data->urlCover;
            $f3 = require('cover.php');
        }
        else
        {
            ?>
            <div  style="border: 1px solid #ccc; padding: 70px 0; overflow:  ">
                <div class="large-30"></div>
                <div class="large-20">
                    <div id="singleFile">Upload Photo</div>
                </div>
                <div class="large-20"><div style="padding: 5px 0">    
                        <a href="#" id="myPhotoGroup" rel="<?php echo $group->recordID ?>" title="My Photos">Choose from My Photos</a>
                    </div>
                </div>
                <div class="large-40"></div>
            </div>
        <?php } ?>
    </div>
    <?php $f3 = require('groupBar.php'); ?>
    <div class="uiMainColProfile uiMainContainer large-70">
        <?php
        FactoryUtils::element('formPost', array('module' => 'post'));
        ?>
        <input type="hidden" id="type" name="type" value="group">
        <input type="hidden" id="typeID" name="typeID" value="<?php echo $group->recordID ?>">

        <div id="contentContainer">

        </div> 

    </div>
    <div id="modalGroup">
        <div class="modalGroupHeader">
            <h2>Create group</h2>
        </div>
        <?php $f3 = require('form.php'); ?>
    </div>
    <div id="dialog">

    </div>
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

</script>
<div class="large-100">
    <form id="coverPhotoGroup">
        <input type="hidden" id="groupID" name="groupID" value="<?php echo $group->recordID ?>">
        <div class="column-group coverGroup">
            <div class="displayPhoto">
                <?php
                if (!empty($group->data->cover))
                {
                    $photo = GroupController::findPhoto($group->data->cover);
                    if (!empty($photo))
                    {
                        ?>
                        <div class="imgCover">
                            <div style="width:<?php echo $photo->data->width ?>px; height:<?php echo $photo->data->height ?>px;  position: relative; <?php if (!empty($group->data->drapx)) echo 'left: -' . $group->data->drapx . 'px' ?>; <?php if (!empty($group->data->drapy)) echo 'top: -' . $group->data->drapy . 'px' ?>">
                                <img src="<?php echo UPLOAD_URL . $photo->data->fileName ?>" style="width:100%;">
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <div class="uploadCoverGroup">
                        <div class="large-30"></div>
                        <div class="large-20">
                            <div id="uploadPhotoGroup">Upload Photo</div>
                        </div>
                        <div class="large-20"><div style="padding: 5px 0">    
                                <a href="#" class="myPhotoGroup" rel="<?php echo $group->recordID ?>" title="My Photos">Choose from My Photos</a>
                            </div>
                        </div>
                        <div class="large-40"></div>
                    </div>
                <?php } ?>
            </div>
            <div class="actionCover">
                <?php
                if (!empty($group->data->cover))
                {
                    ?>
                    <div class="dropdown">
                        <a href="#" class="button"><span class="icon icon148"></span><span class="label">Change cover</span></a>
                        <div class="dropdown-slider w175">
                            <a href="#" class="myPhotoGroup ddm"  rel="<?php echo $group->recordID ?>" title="My Photos"><span class="icon icon147"></span><span class="label">Choose from Photos...</span></a>
                            <a href="#" class="ddm"><div id="uploadPhotoGroup"><span class="icon icon189"></span><span class="label">Upload photo</span></div></a>
                            <?php
                            if (!empty($photo))
                            {
                                ?>
                                <a href="javascript:void(0)" class="ddm rCoverGroup" rel="<?php echo $photo->recordID ?>"><span class="icon icon61"></span><span class="label">Reposition...</span></a>
                                <?php
                            }
                            if (!empty($group->data->cover))
                            {
                                ?>
                                <a href="javascript:void(0)" class="removeImgGroup ddm" rel="<?php echo $photo->recordID ?>" title="Remove"><span class="icon icon58"></span><span class="label">Remove</span></a>
                            <?php } ?>
                        </div> <!-- /.dropdown-slider -->
                    </div> <!-- /.dropdown -->
                <?php } ?>
            </div>
        </div>
    </form>
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
    <script>
        $(function() {
            $("#coverPhotoGroup").submit(function() {
                $.ajax({
                    type: "POST",
                    url: "/content/group/ajax/comfirmcover",
                    data: $("#coverPhotoGroup").serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        $('.actionCover').css('display', 'block');
                        $(".submit").html(data);
                    }
                });

                return false; // avoid to execute the actual submit of the form.
            });
        });
        $("body").on('click', '.removeImgGroup', function(e) {
            var title = $(this).attr('title');
            var data = [
                {rel: $(this).attr('rel'), groupID: $('#groupID').val()},
            ];
            $(".dialog").dialog({
                width: "500",
                height: "160",
                position: ['top', 100],
                title: title,
                resizable: true,
                modal: true,
                open: function(event, ui) {
                    $(".ui-dialog-titlebar-close").hide();
                    $("#alertTemplate").tmpl(data).appendTo(".dialog");
                }
            });
        });

    </script>
    <script id="removeCoverGroupTemplate" type="text/x-jQuery-tmpl">
        <div class="uploadCoverGroup">
        <div class="large-30"></div>
        <div class="large-20">
        <div id="uploadPhotoGroup">Upload Photo</div>
        </div>
        <div class="large-20"><div style="padding: 5px 0">    
        <a href="#" class="myPhotoGroup" rel="<?php echo $group->recordID ?>" title="My Photos">Choose from My Photos</a>
        </div>
        </div>
        <div class="large-40"></div>
        </div>
    </script>

    <script id="alertTemplate" type="text/x-jQuery-tmpl">
        <div class="control-group">
        <div class="control">
        <div class="statusDialog">Are you sure you want to remove </div>
        </div>
        </div>
        <input type="hidden" name="photoID" value="${rel}">
        <input type="hidden"  name="groupID" value="${groupID}">
        <div class="footerDialog" >
        <div class="float-right">
        <button type="submit" class="ink-button green-button comfirmDialogGroup">Comfirm</button>
        <button class=" closeDialog ink-button ">Cancel</a>
        </div>
        </div>
    </script>
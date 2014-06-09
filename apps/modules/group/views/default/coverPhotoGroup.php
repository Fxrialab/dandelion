<form id="coverPhotoGroup">
    <input type="hidden" id="groupID" name="groupID" value="<?php echo $group->recordID ?>">
    <?php
    if ($group->data->coverGroup != 'none')
        $photo = ElementController::findPhoto($group->data->coverGroup);
    if (!empty($photo))
    {
        $a = 'Change cover';
    }else {
        $a = 'Add a cover';
    }
    ?>
    <div class="column-group coverGroup">
        <div class="displayPhoto">
            <?php
            if (!empty($photo))
            {
                ?>
                <div class="imgCoverGroup">
                    <div style="width:<?php echo $photo->data->width ?>px; height:<?php echo $photo->data->height; ?>px;  position: relative; <?php if (!empty($photo->data->dragX)) echo 'left: -' . $photo->data->dragX . 'px' ?>; <?php if (!empty($photo->data->dragY)) echo 'top: -' . $photo->data->dragY . 'px' ?>">
                        <img src="<?php echo UPLOAD_URL .'cover/750px/' .$photo->data->fileName; ?>" style="width:100%;">
                    </div>
                </div>
            <?php
            }?>
        </div>
        <?php
        $currentUser = $this->f3->get('SESSION.userID');
        if ($currentUser == $group->data->owner)
        {
            ?>
            <div class="actionCover">
                <div class="dropdown">
                    <a href="#" class="button"><span class="icon icon148"></span><span class="label"><?php echo $a; ?></span></a>
                    <div class="dropdown-slider w175">
                        <a class="myPhotoGroup ddm"  rel="<?php echo $group->recordID; ?>" title="My Photos"><span class="icon icon147"></span><span class="label">Choose from Photos...</span></a>
                        <a class="ddm"><div id="uploadPhotoGroup"><span class="icon icon189"></span><span class="label">Upload photo</span></div></a>
                        <?php
                        if (!empty($photo))
                        {
                        ?>
                            <a href="javascript:void(0)" class="ddm rCoverGroup" rel="<?php echo $photo->recordID; ?>"><span class="icon icon61"></span><span class="label">Reposition...</span></a>
                            <a href="javascript:void(0)" class="removeImgGroup ddm" rel="<?php echo $photo->recordID; ?>" title="Remove"><span class="icon icon58"></span><span class="label">Remove</span></a>
                        <?php
                        } ?>
                    </div> <!-- /.dropdown-slider -->
                </div> <!-- /.dropdown -->
            </div>
        <?php
        }
        ?>
    </div>
</form>
<script>
    $(function() {
        $("#coverPhotoGroup").submit(function() {

            $.ajax({
                type: "POST",
                url: "/content/group/saveCover",
                data: $("#coverPhotoGroup").serialize(), // serializes the form's elements.
                success: function()
                {
                    $('.actionCoverGroup').css('display', 'none');
                    $('.actionCover').css('display', 'block');
                    $('.dragCover').css('cursor', 'pointer');
                }
            });
            return false; // avoid to execute the actual submit of the form.
        });
    });
</script>
<script id="navCoverPhotoGroupTemplate" type="text/x-jQuery-tmpl">
    <div class="cancelCover">
        <nav class="ink-navigation uiTimeLineHeadLine">
            <ul class="menu horizontal uiTimeLineHeadLine float-right">
                <li><button type="button" class="ink-button cancel" id="coverPhoto">Cancel</button></li>
                <li><button type="submit" class="ink-button green-button">Save Changes</button></li>
            </ul>
        </nav>
    </div>
</script>
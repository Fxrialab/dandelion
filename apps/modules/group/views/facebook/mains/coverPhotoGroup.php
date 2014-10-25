<form id="coverPhotoGroup">
    <input type="hidden" id="groupID" name="groupID" value="<?php echo $group->recordID ?>">
    <?php
    if ($group->data->coverGroup != 'none')
        $photo = HelperController::findPhoto($group->data->coverGroup);
    if (!empty($photo))
    {
        $a = 'Change cover';
    }
    else
    {
        $a = 'Add a cover';
    }
    ?>
    <div class="column-group coverGroup">
        <div class="displayPhoto">
            <div class="msg" style="position: absolute; top: 0; right: 20px"></div>
            <?php
            if (!empty($photo))
            {
                ?>
                <div class="imgCoverGroup">
                    <div style="width:<?php echo $photo->data->width ?>px; height:<?php echo $photo->data->height; ?>px;  position: relative; <?php if (!empty($photo->data->dragX)) echo 'left: -' . $photo->data->dragX . 'px' ?>; <?php if (!empty($photo->data->dragY)) echo 'top: -' . $photo->data->dragY . 'px' ?>">
                        <img src="<?php echo UPLOAD_URL . 'cover/750px/' . $photo->data->fileName; ?>" style="width:100%;">
                    </div>
                </div>
            <?php }
            ?>
        </div>
        <?php
        $currentUser = $this->f3->get('SESSION.userID');
        if ($currentUser == $group->data->owner)
        {
            ?>
            <div class="actionCover">
                <a data-dropdown="#dropdown-uploadCover" class="button icon add"><span><?php echo $a ?></span></a>
                <div id="dropdown-uploadCover" class="dropdown dropdown-tip">
                    <ul class="dropdown-menu">
                        <li><a href="/content/group/photoBrowsers?id=<?php echo $group->recordID ?>" class="popupMyPhoto" title="My Photos">Choose from Photos...</a></li>
                        <li><a id="uploadPhotoGroup">Upload photo</a></li>
                        <?php
                        if (!empty($photo))
                        {
                            ?>
                            <li><a href="javascript:void(0)" class="rCoverGroup" rel="<?php echo $photo->recordID ?>">Reposition</a></li>
                            <li><a href="javascript:void(0)" class="removeImgGroup" id="removeCover" rel="<?php echo $photo->recordID; ?> title="Remove">Remove</a></li>
                            <?php
                        }
                        ?>
                    </ul>

                </div>

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
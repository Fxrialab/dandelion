<form id="coverPhotoGroup" style="margin: 0">
    <input type="hidden" id="groupID" name="groupID" value="<?php echo $group->recordID ?>">
    <?php
    
    if ($group->data->coverGroup != 'none'){
        $findPhoto = ElementController::findPhoto($group->data->coverGroup);
    }
    if (!empty($findPhoto))
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
            if (!empty($findPhoto))
            {
                ?>
                <div class="imgCoverGroup">
                    <div style="width:<?php echo $findPhoto->data->width ?>px; height:<?php echo $findPhoto->data->height; ?>px;  position: relative; <?php if (!empty($findPhoto->data->dragX)) echo 'left: -' . $findPhoto->data->dragX . 'px' ?>; <?php if (!empty($findPhoto->data->dragY)) echo 'top: -' . $findPhoto->data->dragY . 'px' ?>">
                        <img src="<?php echo UPLOAD_URL . 'cover/750px/' . $findPhoto->data->fileName; ?>" style="width:100%;">
                    </div>
                </div>
            <?php }
            ?>
        </div>
        <?php
        $currentUser = F3::get('SESSION.userID');
        if ($currentUser == $group->data->owner)
        {
            ?>
            <div class="actionCover">
                <div class="menuClick">
                    <a id="linkCoverGroup" class="button icon add"><span><?php echo $a ?></span></a>
                    <div id="divCoverGroup" class="divmenu">
                        <nav class="ink-navigation">
                            <ul class="menu vertical ">
                                <li><a class="myPhotoGroup"  rel="<?php echo $group->recordID; ?>" title="My Photos"><span class="icon icon147"></span><span class="label">Choose from Photos...</span></a></li>
                                <li><a href="javascript:void(0)"><div id="uploadPhotoGroup"><span class="icon icon189"></span><span class="label">Upload photo</span></div></a></li>
                                <?php
                                if (!empty($findPhoto))
                                {
                                    ?>
                                    <li><a href="javascript:void(0)" class="ddm rCoverGroup" rel="<?php echo $findPhoto->recordID; ?>"><span class="icon icon160"></span><span class="label">Reposition...</span></a></li>
                                    <li>   <a href="javascript:void(0)" class="removeImgGroup ddm" rel="<?php echo $findPhoto->recordID; ?>" title="Remove"><span class="icon icon58"></span><span class="label">Remove</span></a></li>
                                <?php }
                                ?>
                            </ul>
                        </nav>


                    </div>
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
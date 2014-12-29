<form id="coverPhotoGroup">
    <input type="hidden" id="groupID" name="groupID" value="<?php echo $data['group']->recordID ?>">
    <div class="column-group coverGroup">
        <div class="displayPhoto">
            <div class="msg" style="position: absolute; top: 0; right: 20px"></div>
            <?php
            if ($data['group']->data->coverGroup != 'none')
            {
                ?>
                <div class="imgCoverGroup">
                    <div style="position: relative; top: <?php echo !empty($data['cover']) ? '-' . $data['cover']->data->dragY.'px' : '0' ?>"; left: <?php echo !empty($data['cover']) ? '-' . $data['cover']->data->dragX.'px' : '0' ?>">
                        <img src="<?php echo $this->getImg($data['cover']->recordID) ?>" style="width:100%;">
                    </div>
                </div>
            <?php }
            ?>
        </div>
        <?php
        $currentUser = $this->f3->get('SESSION.userID');
        if ($currentUser == $data['group']->data->owner)
        {
            ?>
            <div class="actionCover">
                <a data-dropdown="#dropdown-uploadCover"><i class="fa fa-camera fa-24" ></i></a>
                <div id="dropdown-uploadCover" class="dropdown dropdown-tip">
                    <ul class="dropdown-menu">
                        <li><a href="/content/group/photoBrowser?id=<?php echo $data['group']->recordID ?>" class="popupMyPhoto"  title="Choose From My Photos"><i class="fa fa-image"></i>Choose from Photos...</a></li>
                        <li><a id="uploadPhotoGroup"><i class="fa fa-upload"></i>Upload photo</a></li>
                        <?php
                        if (!$data['group']->data->coverGroup != 'none')
                        {
                            ?>
                            <li><a href="javascript:void(0)" class="rCoverGroup" rel="<?php echo $data['group']->data->coverGroup ?>"><i class="fa fa-arrows-alt"></i>Reposition</a></li>
                            <li><a href="javascript:void(0)" class="removeImgGroup" id="removeCover" rel="<?php echo $data['group']->data->coverGroup ?>" title="Remove"><i class="fa fa-remove"></i>Remove</a></li>
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


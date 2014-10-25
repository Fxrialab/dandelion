
<div class="arrow_timeLineMenuNav">
    <div class="arrow_phototab"></div>
</div>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <?php $f3 = require('boxTitle.php'); ?>
        <input type="hidden" id="userID" value="<?php echo $this->f3->get('userID') ?>">
        <input type="hidden" id="albumID" value="<?php echo $this->f3->get('albumID') ?>">
        <div class="arrow_photo"></div>
        <div class="column-group">
            <?php
            $photo = F3::get('photo');
            foreach ($photo as $k => $value)
            {
                ?>
                <div class="large-33">
                    <div class="photoItems">
                        <a class="popupPhoto page" href="/content/photo/popupPhoto?pID=<?php echo $value->data->actor ?>_0_<?php echo $value->recordID ?>_<?php echo $k ?>">
                            <img src="<?php echo UPLOAD_URL . 'images/' . $value->data->fileName ?>" height="200">
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
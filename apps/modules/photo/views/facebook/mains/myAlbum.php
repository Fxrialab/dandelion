
<?php
$album = $this->f3->get('album');
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
        <input type="hidden" id="albumID" value="">
        <div class="arrow_album"></div>
        <div class="column-group">
            <div class="photoAll">
                <?php
                if (!empty($album))
                {
                    foreach ($album as $value)
                    {
                        $photo = HelperController::photoAlbum($value->recordID);
                        ?>
                        <div class="large-33">
                            <div class="photoItems">
                                <a href="/content/photo/media?id=<?php echo str_replace(':', '_',$value->recordID) ?>">
                                    <img src="<?php echo UPLOAD_URL . 'images/' . $photo[0]->data->fileName ?>" height="200">
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>



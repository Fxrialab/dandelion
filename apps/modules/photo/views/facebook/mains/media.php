
<?php
$album = $this->f3->get('album');
$photo = $this->f3->get('photo');
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
        <div class="column-group">
            <div class="photoAll" style="text-align: center">
                                <?php
                echo '<h3 style="padding:30px">' . $album->data->name . '</h3>';
                ?>
                <?php
                if (!empty($photo))
                {
                    foreach ($photo as $k => $value)
                    {
                        $recordID = $value->recordID;
                        $actor = $value->data->actor;
                        $photoName = $value->data->fileName;
                        $numberLike = $value->data->numberLike;
                        $photoID = str_replace(':', '_', $recordID);
                        $comment = HelperController::getFindComment($recordID);
                        $count = HelperController::countComment($recordID);
                        $like = HelperController::like($recordID);
                        $f3 = require('photoItem.php');
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>


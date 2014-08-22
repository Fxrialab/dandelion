
<?php
$album = F3::get('album');
?>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <?php require_once 'boxTitle.php'; ?>
        <div class="arrow_album"></div>
        <div class="column-group">
            <div class="photoAll">
                <?php
                if (!empty($album))
                {
                    foreach ($album as $value)
                    {
                        ?>
                        <div class="large-33">
                            <div class="photoItems">
                                <?php
                                $photo = explode(',', $value->data->photo);
                                $p = PhotoController::getPhoto($photo[0]);
                                $u = PhotoController::getUser($value->data->owner);
                                ?>
                                <a href="/content/photo?user=<?php echo $u->data->username ?>&album=<?php echo str_replace(':', '_', $value->recordID) ?>" class="viewThisPhoto">
                                    <img src="<?php echo UPLOAD_URL . $p->data->fileName ?>">
                                </a>
                                <div style="border: 1px solid #ccc; margin-top: -2px; padding: 5px;">
                                    <a style=" font-weight: bold" href="/content/photo?user=<?php echo $u->data->username ?>&album=<?php echo str_replace(':', '_', $value->recordID) ?>"> <?php echo $value->data->name ?></a>
                                    <p style="line-height: 20px"><?php echo count($photo) ?> photo</p>
                                </div>
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

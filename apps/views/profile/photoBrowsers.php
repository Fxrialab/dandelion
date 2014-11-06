<?php
$albumName = F3::get('albumName');
$type = F3::get('type');
?>
<div class="popupNav">
    <div class="column-group">
        <div class="large-90">
            <h4><?php echo $albumName ?></h4>
        </div>
        <div class="large-10">
            <a class="popupMax" href="/photoBrowser?user_id=<?php echo F3::get('SESSION.userID') ?>&act=album&type=<?php echo $type ?>" title="Choose From My Photos">Photo Album</a>
        </div>
    </div>
</div>
<div class="column-group mCustomScrollbar" style="height: 500px">
    <?php
    $photos = F3::get('photos');
    if (!empty($photos))
    {
        foreach ($photos as $key => $value)
        {
            ?>
            <div class=" large-25">
                <div class="photoItems">
                    <?php
                    if ($type == 'avatar')
                    {
                        ?>
                        <a class="popupPhoto" href="/content/photo/popupPhoto?pID=<?php echo $this->f3->get('SESSION.userID') ?>_0_<?php echo $value->recordID ?>_0&set=drap">
                            <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $value->data->fileName; ?>)"></i>
                        </a>
                        <?php
                    }
                    else
                    {
                        ?>
                        <a class="changePhoto_<?php echo $type ?>" data-rel="<?php echo $type . ';' . $value->recordID ?>">
                            <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $value->data->fileName; ?>)"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

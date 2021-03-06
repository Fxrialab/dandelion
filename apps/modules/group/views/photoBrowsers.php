<?php
$rid = $this->f3->get('rid');
$albumName = $this->f3->get('albumName');
?>
<div class="popupNav">
    <div class="column-group">
        <div class="large-90">
            <h4><?php echo $albumName ?></h4>
        </div>
        <div class="large-10">
            <a class="popupMax" href="/content/group/photoBrowser?id=<?php echo $rid ?>&act=album" title="Choose From My Photos">Photo Album</a>
        </div>
    </div>
</div>
<div class="column-group mCustomScrollbar" style="height: 500px">
    <?php
    $photos = $this->f3->get('photos');
    if (!empty($photos))
    {
        foreach ($photos as $key => $value)
        {
            ?>
            <div class=" large-25">
                <div class="photoItems">
                    <a class="changePhoto_group" href="/content/group/changePhoto?profile_id=<?php echo $this->f3->get('SESSION.userID') ?>&photo_id=<?php echo $value->recordID ?>">
                        <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $value->data->fileName; ?>)"></i>
                    </a>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

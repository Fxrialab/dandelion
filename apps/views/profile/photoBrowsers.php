<?php
$albumName = $this->f3->get('albumName');
$type = $this->f3->get('type');
$user = $this->f3->get('user');
?>
<div class="popupNav">
    <div class="column-group">
        <div class="large-90">
            <h4><?php echo $albumName ?></h4>
        </div>
        <div class="large-10">
            <a class="popupMax" href="/photoBrowser?user_id=<?php echo $user->recordID ?>&act=album&type=<?php echo $type ?>" title="Choose From My Photos">Photo Album</a>
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
            <div class=" large-20">
                <div class="imgContainer" style="width:166px; height: 126px;">
                    <a class="changePhoto_<?php echo $type ?>" data-rel="<?php echo $type . ';' . $value->recordID ?>">
                        <img src="<?php echo UPLOAD_URL . 'thumbnail/' . $value->data->fileName; ?>">
                    </a>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

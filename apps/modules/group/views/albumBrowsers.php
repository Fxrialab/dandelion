<?php
$album = $this->f3->get('album');
$rid = $this->f3->get('rid');
if (!empty($album))
{
    ?>
    <div class="popupNav">
        <div class="column-group">
            <div class="large-90">
                <h4>Photo Album</h4>
            </div>
            <div class="large-10">
                <a class="popupMax" href="/content/group/photoBrowser?id=<?php echo $rid ?>"  title="Choose From My Photos">Recent Photos</a>
            </div>
        </div>
    </div>
    <div class="column-group mCustomScrollbar" style="height: 500px">
        <?php
        foreach ($album as $key => $v)
        {
            $value = HelperController::photoAlbum($v->recordID);
            ?>
            <div class="large-25">
                <div class="photoItems">
                    <a class="popupMax" href="/content/group/photoBrowser?id=<?php echo $rid ?>&aid=<?php echo $v->recordID ?>" title="Choose From My Photos" >
                        <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $value[0]->data->fileName; ?>)"></i>
                    </a>
                    <h6 style="text-align:center; line-height: 15px"><?php echo $v->data->name ?></h6>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
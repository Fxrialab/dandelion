<?php
$album = $this->f3->get('album');
$user_id = $this->f3->get('user_id');
$type = $this->f3->get('type');
if (!empty($album))
{
    ?>
    <div class="popupNav">
        <div class="column-group">
            <div class="large-90">
                <h4>Photo Album</h4>
            </div>
            <div class="large-10">
                <a class="popupMax" href="/photoBrowser?user_id=<?php echo $user_id ?>&type=<?php echo $type ?>"  title="Choose From My Photos">Recent Photos</a>
            </div>
        </div>
    </div>
    <div class="column-group mCustomScrollbar" style="height: 500px">
        <?php
        foreach ($album as $key => $value)
        {
            ?>
            <div class="large-25">
                <div class="photoItems">
                    <a class="popupMax" href="/photoBrowser?user_id=<?php echo $user_id ?>&type=<?php echo $type ?>&aid=<?php echo $value['album']->recordID ?>" title="Choose From My Photos" >
                        <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $value['photo'][0]->data->fileName; ?>)"></i>
                    </a>
                    <h6 style="text-align:center; line-height: 15px"><?php echo $value['album']->data->name ?></h6>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
<?php
$photoID = str_replace(':', '_', $photo->recordID);
?>
<div class="large-33">
    <div class="photoItems">
        <a class="popupPhoto" href="/content/photo/index?uid=<?php echo $this->getId($photo->data->owner) ?>&sid=0&pid=<?php echo $this->getId($photo->recordID) ?>&page=<?php echo $k ?>">
            <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $photo->data->fileName; ?>)"></i>

        </a>
    </div>

</div>
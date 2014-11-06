<?php
$photoID = str_replace(':', '_', $photo->recordID);
?>
<div class="large-33">
    <div class="photoItems">
        <a class="popupPhoto" href="/content/photo/popupPhoto?pID=<?php echo $actor->recordID ?>_0_<?php echo $photo->recordID ?>_<?php echo $k ?>">
            <i class="mediaThumb" style="background-image:url(<?php echo UPLOAD_URL . 'images/' . $photo->data->fileName; ?>)"></i>

        </a>
    </div>
   
</div>
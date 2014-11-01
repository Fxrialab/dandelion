<?php
if (!empty($photo))
{
    $photoID    = $photo->recordID;
    $fileName   = $photo->data->fileName;
    $width      = $photo->data->width;
    $height     = $photo->data->height;
    $dragX      = $photo->data->dragX;
    $dragY      = $photo->data->dragY;
    ?>
    <input type="hidden" name="coverFile" value="<?php echo $photoID; ?>">
    <input type="hidden" name="width" value="<?php echo $width; ?>">
    <input type="hidden" name="height" value="<?php echo $height; ?>">
    <input type="hidden" name="target" value="isReposition">
    <div class="userCover">
        <input type="hidden" name="dragX" value="<?php echo $dragX; ?>">
        <input type="hidden" name="dragY" value="<?php echo $dragY; ?>">
    </div>
    <div class="dragCover" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px;  <?php echo 'left: -' . $dragX . 'px' ?>; <?php echo 'top: -' . $dragY . 'px' ?>; cursor: move">
        <img src="<?php echo UPLOAD_URL ."cover/750px/". $fileName ?>" style="width:100%;">
    </div>
    <script>
    //Drap and drop images
        $('.dragCover').draggable({
            drag: function() {
                var offset = $(this).offset();
                var x = Math.abs(offset.left);
                var y = Math.abs(offset.top);
                $('.userCover').html('<input type="hidden" name="dragX" value="' + x + '"><input type="hidden" name="dragY" value="' + y + '">');
            },
            stop: function(event, ui) {
                // Show dropped position.
                var Stoppos = $(this).position();
                var left = Math.abs(Stoppos.left);
                var top = Math.abs(Stoppos.top);
                $('.userCover').html('<input type="hidden" name="dragX" value="' + left + '"><input type="hidden" name="dragY"  value="' + top + '">');
            }

        });
    </script>
<?php
}
?>
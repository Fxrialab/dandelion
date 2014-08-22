<?php
$image = F3::get('image');
?>
<div class="imgCover">
    <div class="userCover">
        <input type="hidden" name="dragX" value="0">
        <input type="hidden" name="dragY" value="0">
    </div>
    <input type="hidden" name="coverFile" value="<?php echo $image['name']; ?>">
    <input type="hidden" name="width" value="<?php echo $image['width']; ?>">
    <input type="hidden" name="height" value="<?php echo $image['height']; ?>">
    <input type="hidden" name="target" value="<?php echo $target; ?>">
    <input type="hidden" name="chooseBy" value="cover">
    <div class="dragCover" style="width: <?php echo $image['width']; ?>px; height:<?php echo $image['height']; ?>px; cursor: move">
        <img src="<?php echo UPLOAD_URL . "cover/750px/" . $image['name']; ?>" style="width:100%;">
    </div>
    <script>
        $('.dragCover').draggable({
            stop: function(event, ui) {
                var Stoppos = $(this).position();
                var left = Math.abs(Stoppos.left);
                var top = Math.abs(Stoppos.top);
                $('.userCover').html('<input type="hidden" name="dragX" value="' + left + '"><input type="hidden" name="dragY"  value="' + top + '">');
            }

        });
    </script>
</div>

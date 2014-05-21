<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<input type="hidden" name="cover" value="<?php echo $photoID ?>">
<div class="userCover">
    <input type="hidden" name="drapx" value="<?php if (!empty($drapx)) echo $drapx ?>">
    <input type="hidden" name="drapy" value="<?php if (!empty($drapx)) echo $drapy ?>">
</div>
<div class="dragCover" style="width:<?php echo $width ?>px; height:<?php echo $height ?>px;  <?php if (!empty($drapx)) echo 'left: -' . $drapx . 'px' ?>; <?php if (!empty($drapy)) echo 'top: -' . $drapy . 'px' ?>; cursor: move">
    <img src="<?php echo UPLOAD_URL . $fileName ?>" style="width:100%;">
</div>
<script>
//Drap and drop images
    $('.dragCover').draggable({
        drag: function() {
            var offset = $(this).offset();
            var x = Math.abs(offset.left);
            var y = Math.abs(offset.top);
            $('.userCover').html('<input type="hidden" name="drapx" value="' + x + '"><input type="hidden" name="drapy" value="' + y + '">');
        },
        stop: function(event, ui) {
            // Show dropped position.
            var Stoppos = $(this).position();
            var left = Math.abs(Stoppos.left);
            var top = Math.abs(Stoppos.top);
            $('.userCover').html('<input type="hidden" name=drapx value="' + left + '"><input type="hidden" name=drapy  value="' + top + '">');
        }

    });
</script>
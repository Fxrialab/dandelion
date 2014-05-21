<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($photo))
{
    $remove = '<a href="#" class="ddm"><span class="icon icon58"></span><span class="label">Remove</span></a>';
    $lable = 'Edit a cover';
}
else
{
    $remove = '  <a href="#" class="ddm"><span class="icon icon58"></span><span class="label">Remove</span></a>';
    $lable = 'Add a cover';
}
$p = AjaxController::findPhoto($photo->recordID);
?>

<div class="imgCover">
    <div class="userCover">
        <input type="hidden" name="drapx" value="0">
        <input type="hidden" name="drapy" value="0">
    </div>
    <input type="hidden" name="cover" value="<?php echo $photo->recordID ?>">
    <div class="dragCover" style="width:<?php if (!empty($p->data->width)) echo $p->data->width ?>px; height:<?php if (!empty($p->data->height)) echo $p->data->height ?>px; cursor: move">
        <img src="<?php echo UPLOAD_URL . $p->data->fileName ?>" style="width:100%;">
    </div>
    <script>
        $('.dragCover').draggable({
            stop: function(event, ui) {

                // Show dropped position.
                var Stoppos = $(this).position();
                var left = Math.abs(Stoppos.left);
                var top = Math.abs(Stoppos.top);
                $('.userCover').html('<input type="hidden" name=drapx value="' + left + '"><input type="hidden" name=drapy  value="' + top + '">');
            }

        });
    </script>
</div>

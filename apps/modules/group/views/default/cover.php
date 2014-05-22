<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//if (!empty($urlCover))
//{
//    $background = $urlCover;
//    $groupID = $groupID;
//}
//else
//{
//    $photo = $this->f3->get('photo');
//    $groupID = 11;
//}

$p = $this->f3->get('photo');
$group = $this->f3->get('group');
?>

<div class="imgCover">
    <div class="groupCover">
        <input type="hidden" name="drapx" value="0">
        <input type="hidden" name="drapy" value="0">
    </div>
    <input type="hidden" name="cover" value="<?php echo $p->recordID ?>">
    <div class="dragCover" style="width:<?php if (!empty($p->data->width)) echo $p->data->width ?>px; height:<?php if (!empty($p->data->height)) echo $p->data->height ?>px; position: relative;left:<?php if (!empty($group->data->drapx)) echo '-' . $group->data->drapx ?>px; top:<?php if (!empty($group->data->drapy)) echo '-' . $group->data->drapy ?>px; cursor: move">
        <img src="<?php echo UPLOAD_URL . $p->data->fileName ?>" style="width:100%;">
    </div>
    <script>
        $('.dragCover').draggable({
            stop: function(event, ui) {

                // Show dropped position.
                var Stoppos = $(this).position();
                var left = Math.abs(Stoppos.left);
                var top = Math.abs(Stoppos.top);
                $('.groupCover').html('<input type="hidden" name=drapx value="' + left + '"><input type="hidden" name=drapy  value="' + top + '">');
            }

        });
    </script>
</div>
<input class="ink-button green-button" type="submit" value="Save">
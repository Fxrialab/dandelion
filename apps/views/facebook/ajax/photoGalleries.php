<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class=" column-group">
    <?php
    if (!empty($photos))
    {
        foreach ($photos as $key => $value)
        {
            $find = AjaxController::findPhoto($value->recordID);
            if ($role == 'avatar')
                $id = 'chooseAvatar';
            else
                $id = 'chooseItem';
            ?>
            <div class="large-20">
                <a href="#" id="<?php echo $id ?>" role="<?php echo $role ?>" rel="<?php echo $value->recordID ?>">
                    <img src="<?php echo UPLOAD_URL ."thumbnails/150px/". $find->data->fileName ?>" width="140" height="100" style="padding: 5px">
                </a>
            </div>
            <?php
        }
    }
    ?>
</div>

<div class="footerDialog">
    <div class="float-right">
        <button type="button" class="closeDialog ink-button">Cancel</button>
    </div>
</div>
<script>

</script>

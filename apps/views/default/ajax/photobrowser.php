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
            ?>
            <div class=" large-20"><a href="#" id="chooseItem" rel="<?php echo $value->recordID ?>"><img src="<?php echo $find->data->url ?>" style="padding: 5px"></a></div>
            <?php
        }
    }
    ?>
</div>

<div class="footerDialog">
    <button type="button" class="closeDialog ink-button">Cancel</button>
</div>

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($urlCover))
{
    $background = $urlCover;
    $groupID = $groupID;
}
else
{
    $photo = $this->f3->get('photo');
    $background = $photo->data->url;
    $groupID = 11;
}
?>
<div class="cover" style="background-image: url(<?php echo $background ?>); position: relative">
    <input type="hidden" name="urlCover" value="<?php echo $background ?>">

    <?php
    if (empty($urlCover))
    {
        ?>
        <div class="submit float-right">
            <button type="submit" class="ink-button green-button">Submit</button>
        </div>
        <?php
    }
    else
    {
        ?>
        <?php $f3 = require('editCover.php'); ?>

    <?php } ?>
</div>

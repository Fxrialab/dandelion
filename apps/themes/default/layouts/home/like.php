<?php
$objID = str_replace(':', '_', $objectID);
if (!empty($liked))
{
    ?>
    <a class="unlikeAction" rel="<?php echo $type ?>" id="<?php echo $objID; ?>" title="Unlike">Unlike</a>
    <?php
}
else
{
    ?>
    <a class="likeAction" rel="<?php echo $type ?>" id="<?php echo $objID; ?>" title="Like">Like</a>
    <?php
}
?>

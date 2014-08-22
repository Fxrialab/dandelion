<?php
$liked = F3::get('liked');
$objectID = F3::get('objectID');
$type = F3::get('type');
$objID = str_replace(':', '_', $objectID);
if ($liked == TRUE)
{
    ?>
    <a class="unlikeAction ink-button" rel="<?php echo $type ?>" id="<?php echo $objID; ?>" title="Unlike">Unlike</a>
    <?php
}
else
{
    ?>
    <a class="likeAction ink-button" rel="<?php echo $type ?>" id="<?php echo $objID; ?>" title="Like">Like</a>
    <?php
}
?>

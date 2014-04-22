<?php
$objID   = str_replace(':', '_', $objectID);
if (!empty($liked))
{
    ?>
    <a class="unlikeAction" id="<?php echo $objID; ?>" title="Unlike post">Unlike</a>
<?php
}else {
    ?>
    <a class="likeAction" id="<?php echo $objID; ?>" title="Like post">Like</a>
<?php
}
?>

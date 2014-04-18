<?php
$objID   = str_replace(':', '_', $objectID);
if (!empty($liked))
{
    ?>
    <a href="javascript:void(0)" onclick="new Unlike('<?php echo $type; ?>','<?php echo $objID; ?>')" title="Unlike post">Unlike</a>
<?php
}else {
    ?>
    <a href="javascript:void(0)" onclick="new Like('<?php echo $type; ?>','<?php echo $objID; ?>')" title="Like post">Like</a>
<?php
}
?>


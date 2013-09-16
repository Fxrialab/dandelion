<?php
$actionIDArrays = F3::get('actionIDArrays');
$randomKeys     = F3::get('randomKeys');
$listActions    = F3::get('listActions');
//var_dump($listActions);
foreach ($randomKeys as $key)
{
?>
    <div class="<?php echo $listActions[$actionIDArrays[$key]][0]->data->actionElement; ?>">
    </div>
<?php
}

?>
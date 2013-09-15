<?php
$listActions = F3::get('listActions');
//var_dump($listActions);
foreach ($listActions as $action)
{
    //echo $action->data->actionElement;
?>
    <div class="<?php echo $action->data->actionElement; ?>">
    </div>
<?php
}

?>
<?php
//var_dump($actionElement);
$actionElement = $this->f3->get('actionElement');
if (!empty($actionElement))
{
    foreach ($actionElement as $action)
    {
        ?>
        <div class="<?php echo $action; ?>"></div>
        <?php
    }
}
?>
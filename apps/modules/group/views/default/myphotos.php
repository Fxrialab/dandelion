<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>


</script>
<style>
    .footerDialog{
        text-align: right;
        background: #ccc; position: absolute; bottom: 0; left: 0; width: 100%
    }
</style>
<div class=" column-group">
    <?php
    $photos = $this->f3->get('photos');
    if (!empty($photos))
    {
        foreach ($photos as $key => $value)
        {
            ?>
            <div class=" large-20"><a href="#" class="choosePhoto" rel="<?php echo $value->recordID ?>" id="<?php echo $this->f3->get('groupID') ?>" ><img src="<?php echo $value->data->url ?>" style="padding: 5px"></a></div>
            <?php
        }
    }
    ?>
</div>

<div class="footerDialog">
    <button type="button" class="closeDialog ink-button red">Cancel</button>
</div>

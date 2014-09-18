<div class=" column-group" style="overflow: scroll; height: 310px">
    <?php
    $photos = $this->f3->get('photos');
    if (!empty($photos))
    {
        foreach ($photos as $key => $value)
        {
            ?>
            <div class=" large-20">
                <a href="#" class="choosePhoto" rel="<?php echo $value->recordID ?>" id="<?php echo $this->f3->get('groupID') ?>" >
                    <img src="<?php echo UPLOAD_URL .'thumbnails/150px/'. $value->data->fileName; ?>" style="padding: 5px">
                </a>
            </div>
            <?php
        }
    }
    ?>
</div>
<div class="footerDialog">
    <button type="button" class="closeDialog ink-button">Cancel</button>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //        $('#scrollbar1').tinyscrollbar();
        $('html, body').animate({
            scrollTop: $("#scrollbar1").offset().top
        }, 2000);
    });
</script>

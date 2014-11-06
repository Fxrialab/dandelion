<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$photo = $this->f3->get('photo');
?>
<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>modalPhoto.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->f3->get('WEBROOT'); ?>libs/jcrop/jquery.Jcrop.css" type="text/css" />

<script type="text/javascript" src="<?php echo $this->f3->get('WEBROOT'); ?>libs/pgwmodal/jquery.pgw.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('WEBROOT'); ?>libs/pgwmodal/pgwmodal.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('WEBROOT'); ?>libs/jcrop/jquery.Jcrop.js"></script>
<style>
    #pgwModal .pm-content {
        text-align: center;
        z-index: 9020;
        height: 500px;
    }
</style>

<img style="vertical-align: middle" src="<?php echo UPLOAD_URL . 'images/' . $photo->data->fileName; ?>" id="target">



            <!--<a class="close" href="/user/<?php // echo $this->f3->get('SESSION.username')       ?>" style="right: 10px"><i class="icon16-closepopup"></i></a>-->
<a class="close" href="javascript:void(0)" onclick="$.pgwModal('close');"><i class="icon16-closepopup"></i></a>

<script type="text/javascript">
    $(document).ready(function() {
        $('#target').Jcrop({
            minSize: [160, 160],
            maxSize: [160, 160],
            setSelect: [320, 320, 160, 160]
        });

    });

</script>
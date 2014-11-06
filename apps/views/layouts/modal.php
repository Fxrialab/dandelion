<script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>modalPhoto.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->f3->get('WEBROOT'); ?>libs/jcrop/jquery.Jcrop.css" type="text/css" />



<div>

    <?php
    $this->loadContent($page);
    ?>

</div>
<script type="text/javascript" src="<?php echo $this->f3->get('WEBROOT'); ?>libs/pgwmodal/jquery.pgw.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('WEBROOT'); ?>libs/pgwmodal/pgwmodal.js"></script>
<script type="text/javascript" src="<?php echo $this->f3->get('WEBROOT'); ?>libs/jcrop/jquery.Jcrop.js"></script>
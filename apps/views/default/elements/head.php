<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dandelion</title>
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>reset.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>main.css" type="text/css" />
    <!--[if IE 7 ]>
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink-ie7.css" type="text/css" media="screen"
          title="no title">
    <![endif]-->
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery-1.9.1.min.js"></script>

    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/holder.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/autoload.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.autosize.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/blocksit.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.timers-1.2.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.oembed.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/pretty.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/dropDownStyle.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/init.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>/infinitescroll.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/general.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/jquery.uploadfile.min.js"></script>
    <script type="text/javascript">
        jQuery.fn.center = function() {
            this.css("position", "absolute");
            this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
            this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
            return this;
        };
    </script>
</head>
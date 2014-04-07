<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->f3->get('ENCODING'); ?>" />
    <title><?php echo $this->f3->get('site1'); ?></title>
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>reset.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>main.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>popbox.css" type="text/css" />
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
    <script type="text/javascript">
        new LikePostByElement('.likeSegments');
        new FollowByElement('.followPostSegments');

    </script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/general.js"></script>
    <script type="text/javascript">
        jQuery.fn.center = function() {
            this.css("position", "absolute");
            this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
            this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
            return this;
        };

        $(document).ready(function() {

            $('#contentContainer').scrollPagination({
                nop: 5, // The number of posts per scroll to be loaded
                offset: 0, // Initial offset, begins at 0 in this case
                error: 'No More Posts!', // When the user reaches the end this is the message that is
                // displayed. You can change this if you want.
                delay: 500, // When you scroll down the posts will load after a delayed amount of time.
                // This is mainly for usability concerns. You can alter this as you see fit
                scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
                        // but will still load if the user clicks.

            });

        });

    </script>
</head>
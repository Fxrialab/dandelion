<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Dandelion</title>
        <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>reset.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>main.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>token-input-facebook.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>jquery.dropdown.css" type="text/css" />
        <!--[if IE 7 ]>
        <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink-ie7.css" type="text/css" media="screen"
              title="no title">
        <![endif]-->
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/init.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>infinitescroll.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/jquery.uploadfile.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/holder.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/autoload.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.autosize.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/blocksit.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.timers-1.2.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/dropDownStyle.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.tokeninput.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.leanModal.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.selectric.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>jquery.dropdown.js"></script>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/general.js"></script>
        <script type="text/javascript">
            jQuery.fn.center = function() {
                this.css("position", "absolute");
                this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
                this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
                return this;
            };

            $("a[rel*=leanModal]").leanModal();
            $(function() {
                $('a[rel*=leanModal]').leanModal({top: 100, closeButton: ".modal_close"});
            })

        </script>
    </head>
    <body>
        <?php require_once 'topBar.php'; ?>
        <div id="uiContainerWrapper" class="ink-grid">
            <div class="column-group">
                <div class="large-80 borderLineRight">
                    <?php $this->element('leftCol'); ?>
                    <div class="uiMainColTimeLine large-80 borderLineLeft">
                        <div class="mainColWrapper">
                            <?php
                            if ($type == 'modules')
                                $this->loadModules($page);
                            else
                                echo View::instance()->render($page);
                            ?>
                        </div>
                        <div class="uiRightCol large-30">
                            <?php // $this->element('rightCol'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
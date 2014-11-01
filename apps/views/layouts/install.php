<?php
//check loaded page
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->f3->get('ENCODING'); ?>" />
            <title><?php echo $this->f3->get('site2'); ?></title>
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
            <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/validate.js"></script>
        </head>
    <body>
    <div id="uiGlobalContainer" class="mainBg">
        <div id="mainWrapper">
            <div class="ink-grid">
                <div class="column-group">
                    <div class="large-80 medium-100 small-100 push-center content-center">
                        <img src="<?php echo $this->f3->get('IMG'); ?>logo.png">
                    </div>
                </div>
                <?php
                echo View::instance()->render($page);
                ?>
            </div>
        </div>
        <div id="footerWrapper">
            <div class="ink-grid uiRelatedInfo">
                <div class="column-group">
                    <div class="large-80 medium-100 small-100 push-center">
                        <div class="large-40 medium-80 small-100 uiCopyRightDiv">
                            <span class="">Copyright &copy; 2013 Dandelion</span>
                        </div>
                        <div class="large-50 medium-100 small-100 push-right">
                            <nav class="ink-navigation">
                                <ul class="menu horizontal">
                                    <li><a href="">Feedback</a></li>
                                    <li class="lineSpace">|</li>
                                    <li><a href="">Contact Us</a></li>
                                    <li class="lineSpace">|</li>
                                    <li><a href="">About</a></li>
                                    <li class="lineSpace">|</li>
                                    <li><a href="">Term</a></li>
                                    <li class="lineSpace">|</li>
                                    <li><a href="">Privacy Policy</a></li>
                                    <li class="lineSpace">|</li>
                                    <li><a href="">Help</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$finish = $time;
$totaltime = ($finish - $start);
printf ("Page Loaded in %f Seconds.", $totaltime);
echo "<br />";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo F3::get('ENCODING'); ?>" />
        <title><?php echo F3::get('site2'); ?></title>
        <link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>ink.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>reset.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>main.css" type="text/css" />
        <!--[if IE 7 ]>
        <link rel="stylesheet" href="<?php echo F3::get('CSS'); ?>ink-ie7.css" type="text/css" media="screen"
              title="no title">
        <![endif]-->
        <script type="text/javascript" src="<?php echo F3::get('JS'); ?>libs/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS'); ?>libs/ink.min.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS'); ?>libs/ink-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS'); ?>libs/autoload.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS'); ?>customs/validate.js"></script>
    </head>
    <body>
        <div id="uiGlobalContainer">
            <div id="mainWrapper"  class="mainBg">
                <div class="ink-grid">
                    <div class="column-group">
                        <div class="large-30">
                            <a href="/"><img src="<?php echo F3::get('IMG'); ?>logo.png" style="margin-top: 5px"></a>
                        </div>
                        <div class='large-30'></div>
                        <div class='large-40'>

                            <form class="ink-form" method="post" action="/login" id="fmLogIn" style="margin: 0">
                                <fieldset>
                                    <div class="control-group">
                                        <div class="large-40">
                                            <div style="padding: 0 5px;">
                                                <div class="control">
                                                    <label class="float-left" style="color: #fff">Email</label>
                                                    <input type="text" placeholder="Your Email" name="emailLogIn" id="emailLogIn">
                                                    <div class="float-left">
                                                        <input id="cbRememberMe" class="cbRememberMe" type="checkbox" name="persistent" value="1">
                                                        <label for="cbRememberMe" style="color: #fff">Remember Me</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="large-40">
                                            <div style="padding: 0 5px;">
                                                <div class="control">
                                                    <label class="float-left" style="color: #fff">Password</label>
                                                    <input type="password" placeholder="Your Password" name="pwLogIn" id="pwLogIn">
                                                    <div class="float-left"><a  style="color: #fff" href="/forgotPassword">Forgot Password</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="large-15">
                                            <div style="padding-top: 25px;">
                                                <div class='control'>
                                                    <input type="submit" class="ink-button green" id="smLogIn" name="smLogIn" value="Log In">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $error = F3::get('MsgSignIn');
                                    if (!empty($error))
                                        echo '<div class="control-group"><div class="large-100"  style="color: #fff">' . $error . '</div></div>';
                                    ?>

                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="ink-grid">
                <?php
                echo View::instance()->render($page);
                ?>
            </div>
            <div id="footerWrapper">
                <div class="ink-grid uiRelatedInfo">
                    <div class="column-group">
                        <div class="large-60 medium-80 small-100 uiCopyRightDiv">
                            <span class="">Copyright &copy; 2013 Dandelion</span>
                        </div>
                        <div class="large-40 push-right">
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
    </body>
</html>
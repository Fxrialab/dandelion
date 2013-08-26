<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/3/13 - 11:06 AM
 * Project: joinShare Network - Version: 1.0
 */
//check loaded page
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->element('head')?>
<body>
<!--  this for javascript ampq -->

<div id = "container">
    <?php $this->element('header');  ?>
    <div id="mainContainer">
        <div id="content" class="swcontent clearfix">
            <div id="mainContent">
                <div id="leftColHolder">
                    <div id="leftCol">
                        <?php
                        $this->element('profileElement');
                        $this->element('whoViewElement');
                        //$this->element('clubElement');
                        $this->element('followerElement');
                        //$this->elementModules('elementSugFriend','suggest');
                        ?>
                    </div>
                </div>
                <div id="contentCol" class="clearfix">
                    <div id="contentArea">
                        <div class="navMenu">
                            <span><a href="/" class="swNavMenuImg"><img src="<?php echo F3::get('STATIC'); ?>images/searchfriend.png" alt="" /></a></span>
                            <span><a href="/" class="swNavMenuImg"><img src="<?php echo F3::get('STATIC'); ?>images/chatfriend.png" alt="" /></a></span>
                            <span><a href="/" class="swNavMenuImg"><img src="<?php echo F3::get('STATIC'); ?>images/photos.png" alt="" /></a></span>
                            <span><a href="/" class="swNavMenuImg"><img src="<?php echo F3::get('STATIC'); ?>images/qanda.png" alt="" /></a></span>
                            <span><a href="/" class="swNavMenuImg"><img src="<?php echo F3::get('STATIC'); ?>images/postcard.png" alt="" /></a></span>
                        </div>
                        <div class="pagelet_container">
                            <?php  $this->element('pageNav'); ?>
                            <?php
                            if($type =='modules')
                                $this->loadModules($page);
                            else
                                echo F3::render($page) ;
                            ?>
                        </div>
                    </div>
                    <div id="contentBottom"></div>
                </div>
                <div id="rightCol">
                    <?php $this->element('adsElement'); ?>
                </div>
            </div>
        </div>
        <?php $this->element('footer') ?>
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
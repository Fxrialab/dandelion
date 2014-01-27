<?php
//check loaded page
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!DOCTYPE html>
<html lang="en">
<?php $this->element('landingHead'); ?>
<body>
    <div id="uiGlobalContainer" class="mainBg">
        <div id="mainWrapper">
            <div class="ink-grid">
                <?php $this->element('landingHeader'); ?>
                <?php
                echo View::instance()->render($page);
                ?>
            </div>
        </div>
        <?php $this->element('landingFooter'); ?>
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
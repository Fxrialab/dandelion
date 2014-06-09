<?php
//check loaded page
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php'; ?>
<body>
<div id="topBar">
    <?php $this->element('topBarElement'); ?>
</div>
<div id="uiContainerWrapper" class="ink-grid">
    <div class="column-group">
        <div class="large-80 borderLineRight">
            <?php $this->element('leftCol'); ?>
            <div class="uiMainColTimeLine large-80 borderLineLeft">
                <?php $this->element('coverTimeLine'); ?>
                <div class="mainColWrapper">
                    <?php
                    if($type =='modules')
                        $this->loadModules($page);
                    else
                        echo View::instance()->render($page);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div id="sideBar" style="display: none">
        Chat UI
    </div>
    <?php require_once 'footer.php'; ?>
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
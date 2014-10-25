<?php
//check loaded page
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!DOCTYPE html>
<html lang="en">
    <?php $this->including('head'); ?>
    <body>
        <div id="topBar">
            <?php $this->including('topBar'); ?>
        </div>
        <div id="uiContainerWrapper" class="ink-grid">
            <div class="column-group">
                <div class="large-80 borderLineRight">
                    <?php $this->including('leftCol'); ?>
                    <div class="uiMainColTimeLine large-80 borderLineLeft">
                        <?php $this->including('coverTimeLine'); ?>
                        <div class="mainColWrapper">
                            <?php
                            $this->loadContent($page);
                            ?>
                        </div>
                        <div class="uiRightCol large-30">
                            <?php $this->including('rightCol'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sideBar" style="display: none">
                Chat UI
            </div>

        </div>
        <?php $this->including('footer'); ?>
    </body>
</html>
<?php
//$time = microtime();
//$time = explode(" ", $time);
//$time = $time[1] + $time[0];
//$finish = $time;
//$totaltime = ($finish - $start);
//printf("Page Loaded in %f Seconds.", $totaltime);
//echo "<br />";
?>
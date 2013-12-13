<!DOCTYPE html>
<html lang="en">
<?php $this->element('head'); ?>
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
                <div class="uiRightCol large-30">
                    <?php $this->element('rightCol'); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="sideBar" style="display: none">
        Chat UI
    </div>
</div>
</body>
</html>
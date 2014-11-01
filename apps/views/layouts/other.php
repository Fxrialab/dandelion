
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
//                            if (!empty($type))
                                $this->loadContent($page);
//                            else
//                                echo View::instance()->render($page);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sideBar" style="display: none">
                Chat UI
            </div>
            <?php $this->including('footer'); ?>
        </div>
    </body>
</html>

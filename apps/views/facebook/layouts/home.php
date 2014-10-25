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
                    <div class="uiMainCol large-60 borderLineLeft">
                        <?php
//                        if (!empty($type) && $type != 'default')
                            $this->loadContent($page);
//                        else
//                            echo View::instance()->render($page);
//                        $this->content($page);
                        ?>
                    </div>
                    <div class="uiRightCol large-20">
                        <?php $this->including('rightCol'); ?>
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

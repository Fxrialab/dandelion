<!DOCTYPE html>
<html lang="en">
    <?php $this->including('head');?>
    <body>
        <div id="topBar">
            <?php $this->including('topBar'); ?>
        </div>
        <div id="uiContainerWrapper" class="ink-grid">
            <div class="column-group">
                <div class="large-80 borderLineRight">
                    <?php $this->including('leftCol'); ?>
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
        <?php $this->including('footer'); ?>
    </body>
</html>
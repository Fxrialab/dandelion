
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
                    <div class="uiMainCol large-60 borderLineLeft">
                        <?php
                        if ($type == 'modules')
                            $this->loadModules($page);
                        else
                            echo View::instance()->render($page);
                        ?>
                    </div>
                    <div class="uiRightCol large-20">
                        <?php $this->element('rightCol'); ?>
                    </div>
                </div>
            </div>
            <div id="sideBar" style="display: none">
                Chat UI
            </div>
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>

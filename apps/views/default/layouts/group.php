<html lang="en">
    <?php require_once 'head.php'; ?>
    <body>
        <?php // require_once 'topBar.php'; ?>
        <div id="uiContainerWrapper" class="ink-grid">
            <div class="column-group">
                <div class="large-80 borderLineRight">
                    <?php $this->element('leftCol'); ?>
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

        <?php require_once 'footer.php'; ?>
    </body>
</html>
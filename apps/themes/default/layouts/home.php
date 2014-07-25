
<!DOCTYPE html>
<html lang="en">
    <?php require_once 'head.php'; ?>
    <body>
        <div id="topBar">
            <?php require_once 'topBar.php'; ?>
        </div>
        <div id="uiContainerWrapper" class="ink-grid">
            <div class="column-group">
                <div class="large-80 borderLineRight">
                    <?php require_once 'leftCol.php'; ?>
                    <div class="uiMainCol large-60 borderLineLeft">
                        <?php
                            echo View::instance()->render($page);
                        ?>
                    </div>
                    <div class="uiRightCol large-20">
                        <?php require_once 'rightCol.php'; ?>
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

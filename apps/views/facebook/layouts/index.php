<!DOCTYPE html>
<html lang="en">
    <?php $this->including('landingHead'); ?>
    <body>
        <div id="uiGlobalContainer">
            <div id="mainWrapper"  class="mainBg">
                <div class="ink-grid">
                    <?php $this->including('landingHeader'); ?>
                </div>
            </div>
            <div class="ink-grid">
                <?php
                echo View::instance()->render($page);
                ?>
            </div>
            <?php $this->including('landingFooter'); ?>
        </div>
    </body>
</html>
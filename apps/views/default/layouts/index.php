<!DOCTYPE html>
<html lang="en">
<?php $this->element('landingHead'); ?>
<body>
    <div id="uiGlobalContainer" class="mainBg">
        <div id="mainWrapper">
            <div class="ink-grid">
                <?php $this->element('landingHeader'); ?>
                <?php
                echo View::instance()->render($page);
                ?>
            </div>
        </div>
        <?php $this->element('landingFooter'); ?>
    </div>
</body>
</html>
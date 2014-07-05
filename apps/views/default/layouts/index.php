
<!DOCTYPE html>
<html lang="en">
    <?php $this->element('landingHead'); ?>
    <body>
        <div id="uiGlobalContainer">
            <div id="mainWrapper"  class="mainBg">
                <div class="ink-grid">
                    <?php $this->element('landingHeader'); ?>
                </div>
            </div>
            <div class="ink-grid">
                <?php
                echo View::instance()->render($page);
                ?>
            </div>
            <?php $this->element('landingFooter'); ?>
        </div>
    </body>
</html>
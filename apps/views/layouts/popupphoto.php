<!DOCTYPE html>
<html lang="en">
    <?php $this->including('head'); ?>
    <body>
        <div id="topBar">
            <?php $this->including('topBar'); ?>
        </div>
        <div id="uiContainerWrapper" class="ink-grid">
                <div class="pm-content" style="margin-top: 45px">
                    <?php
                    $this->loadContent($page);
                    ?>
                </div>
        </div>
        <?php $this->including('footer'); ?>
    </body>
</html>


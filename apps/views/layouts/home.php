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
                    <div class="uiMainCol large-55 borderLineLeft">
                        <?php
                        $this->loadContent($page);
                        ?>
                    </div>
                    <div class="uiRightCol large-25">
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


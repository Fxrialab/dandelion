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
                    <?php // $this->including('leftCol'); ?>
                    <div class="uiMainColTimeLine large-100 borderLineLeft">
                        <div class="mainColWrapper">
                            <?php
                            $this->loadContent($page);
                            ?>
                        </div>
                   
                    </div>
                </div>
            </div>
        </div>

        <?php $this->including('footer'); ?>
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/group.js"></script>
    </body>
</html>
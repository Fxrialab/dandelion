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
                    <div class="uiMainColTimeLine large-80 borderLineLeft">
                        <div class="mainColWrapper">
                            <?php
                            $this->loadContent($page);
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
        <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/group.js"></script>
        <script id="navCoverPhotoGroupTemplate" type="text/x-jQuery-tmpl">
            <div class="cancelCover">
            <nav class="ink-navigation uiTimeLineHeadLine">
            <ul class="menu horizontal uiTimeLineHeadLine float-right">
            <li><button type="button" class="ink-button cancel" id="coverPhoto">Cancel</button></li>
            <li><button type="submit" class="ink-button green-button">Save Changes</button></li>
            </ul>
            </nav>
            </div>
        </script>
    </body>
</html>
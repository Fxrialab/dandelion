
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
                        <?php $this->including('coverTimeLine'); ?>
                        <div class="mainColWrapper">

                            <div class="arrow_timeLineMenuNav">
                                <div class="arrow_timeLine" style="left: 10%"></div>
                            </div>
                            <div class="uiMainColAbout">
                                <div class="uiAboutBox">
                                    <div class="uiBoxTitle large-100">
                                        <nav class="ink-navigation">
                                            <ul class="breadcrumbs">
                                                <li><a href="#">Profile</a></li>
                                                <li class="active"><a href="#">About</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="uiAboutWrapper large-100">
                                   
                                            <?php
                                            if ($type == 'modules')
                                                $this->loadModules($page);
                                            else
                                                echo View::instance()->render($page);
                                            ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div id="sideBar" style="display: none">
                Chat UI
            </div>
            <?php $this->including('footer'); ?>
        </div>
    </body>
</html>

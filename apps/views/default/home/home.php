
<?php
foreach ($js as $jshome) {
    ?>
    <script type="text/javascript" src="<?php echo $jshome; ?>"></script>
    <?php
}
?>

<style>
    #uploaded_images {width: 800px;margin: 0 auto}
    #uploaded_images div{float:left;padding-left: 10px;}
    .hide{display:none}
</style>

<div class="uiMainContainer">
    <?php
    AppController::elementModules('postWrap', 'post');
    ?>

    <input name="profileID" id="profileID" type="hidden" value="<?php echo $currentProfileID; ?>">
    <!--<div id ="content"></div>-->
    <div class="wrapperContainer">
        <div id="contentContainer">
            <?php
//    
//            if (!empty($activities)) {
//                foreach ($activities as $mod) {
//                    foreach (glob(MODULES . $mod['path'] . 'viewPost.php') as $views) {
//                        require $views;
//                    }
//                }
//            }
            ?>

        </div><!--
        <div class="uiMoreView content-center">
            <div class="loading uiLoadingIcon"></div>
        </div>
    </div>-->
        <!--Other part-->
        <div id="fade" class="black_overlay"></div>
        <div class="uiShare uiPopUp"></div>
        <div class="notificationShare uiPopUp">
            <div class="titlePopUp large-100">
                <span>Success</span>
            </div>
            <div class="mainPopUp large-100">
                <span class="successNotification">That status was shared on your timeline</span>
            </div>
        </div>
    </div>
<!--<repeat group="{{ @js }}" value="{{ @jsMod }}">
    <script type="text/javascript" src="{{ @jsMod }}"></script>
</repeat>-->
<?php
foreach($js as $jshome){
    ?>
    <script type="text/javascript" src="<?php echo $jshome; ?>"></script>
<?php
}
?>
<div class="uiMainContainer">
    <!--<include href="{{ @postWrapper }}" />-->
    <?php
    AppController::elementModules('postWrap','post');
    ?>
    <input name="profileID" id="profileID" type="hidden" value="<?php echo $currentProfileID; ?>">
    <div class="wrapperContainer">
        <div id="contentContainer">
            <?php
            if($existActivities && $activities){
                foreach($activities  as $homeViews){
                    foreach(glob(MODULES.$homeViews['path'].'home.php') as $views){
                        require $views;
                    }
                }
            }
            ?>
            <!--<include href="{{ @views }}" />-->
        </div>
        <div class="uiMoreView content-center">
            <a href="" class="morePost">More</a>
        </div>
    </div>
</div>
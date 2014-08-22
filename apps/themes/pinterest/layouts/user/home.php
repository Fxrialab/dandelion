<?php
foreach ($js as $jshome)
{
    ?>
    <script type="text/javascript" src="<?php echo $jshome; ?>"></script>
    <?php
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".oembed5").oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 768,
                    autoplay: false
                });
        $(window).scroll(function() {
            if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                $('.uiMoreView').show();
                var published = $(".uiBoxPostItem:last .uiBoxPostContainer .uiPostContent .articleSelectOption").find('.swTimeStatus').attr("name");
                var existNoMoreActivity = $('.noMoreActivity').length;
                if (existNoMoreActivity < 1)
                {
                    $.ajax({
                        type: "POST",
                        url: "/morePostHome",
                        data: {published: published},
                        cache: false,
                        success: function(html) {
                            $("#contentContainer").append(html);
                            $('.uiMoreView').hide();
                        }
                    });
                } else {
                    $('.uiMoreView').hide();
                }
            }
        });
    });
</script>

<div class="uiMainContainer">
    <?php
    $this->element('postWrap');
    ?>
    <input name="profileID" id="profileID" type="hidden" value="<?php echo $currentProfileID; ?>">
    <div class="wrapperContainer">
        <div id="contentContainer">
            <?php
            if ($existActivities && $activities)
            {
                foreach ($activities as $homeViews)
                {
                    foreach (glob(MODULES . $homeViews['path'] . 'home.php') as $views)
                    {
                        require $views;
                    }
                }
            }
            ?>
        </div>
        <div class="uiMoreView content-center">
            <div class="loading uiLoadingIcon"></div>
        </div>
    </div>
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
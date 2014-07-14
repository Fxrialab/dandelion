<?php
$loggedUserID = str_replace(':', '_', $loggedUserID);
?>
<script type="text/javascript">
    $(document).ready(function() {
        MQ.queue("userID<?php echo $loggedUserID; ?>").bind("dandelion", "newsFeed.*.<?php echo $loggedUserID; ?>").callback(function(m) {
            //console.log('amqp data: ', m);
            $.ajax({
                 type: "POST",
                 url: "/listenPost",
                 data: {data: m.data, exchange: m.exchange, routingKey: m.routingKey},
                 cache: false,
                 success: function(html) {
                    $("#contentContainer").prepend(html);
                    updateTime();
                 }
             });
        });
        $('#contentContainer').scrollPagination({
            nop: 5, // The number of posts per scroll to be loaded
            offset: 0, // Initial offset, begins at 0 in this case
            error: '', // When the user reaches the end this is the message that is
            // displayed. You can change this if you want.
            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
            // This is mainly for usability concerns. You can alter this as you see fit
            scroll: true // The main bit, if set to false posts will not load as the user scrolls.
                    // but will still load if the user clicks.

        });
        $('#typeActivity').html('<input type=hidden id=type name=type value=post >');

    });
</script>

<style>
    #uploaded_images {width: 800px;margin: 0 auto}
    #uploaded_images div{float:left;padding-left: 10px;}
    .hide{display:none}
</style>

<div class="uiMainContainer">
    <?php
    FactoryUtils::element('formPost', array('module' => 'post'))
    ?>
	<input type="hidden" id="type" name="type" value="post">
    <div class="wrapperContainer">
        <div id="contentContainer">

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
</div>

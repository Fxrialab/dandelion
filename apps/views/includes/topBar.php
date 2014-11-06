<?php
$loggedUserID = str_replace(':', '_', $this->f3->get('SESSION.userID'));
?>
<script type="text/javascript">
    $(document).ready(function() {
        swfobject.embedSWF(
            "<?php echo WEBROOT;?>swfs/amqp.swf?" + Math.random().toString(),
            "AMQPProxy",
            "1",
            "1",
            "9",
            "<?php echo WEBROOT;?>swfs/expressInstall.swf",
            {},
            {
                allowScriptAccess: "always",
                wmode: "opaque",
                bgcolor: "#005B9F"
            },
            {},
            function() {
                //object loaded callback.. useful for debugging
            }
        );
        /********** AMQP for notifications *********/
        MQ.queue("userID<?php echo $loggedUserID; ?>").bind("dandelion", "notifications.*.<?php echo $loggedUserID; ?>").callback(function(m) {
            console.log('amqp data: ', m.data);

            $.ajax({
                type: "POST",
                url: "/notifications",
                data: {data: m.data, exchange: m.exchange, routingKey: m.routingKey},
                cache: false,
                success: function(html) {
                    $("span.countNotifies").css('display', 'block');
                    $("span.countNotifies").html(m.data.count);
                    if (m.data.type == 'like')
                    {
                        $(".tempLike-"+ m.data.target).prepend(html);
                    }else if(m.data.type == 'comment')
                    {
                        $("#commentBox-"+ m.data.target).before(html);
                    }
                    updateTime();
                }
            });
        });
        $('body').on('click', '.notifications', function(){
            if($('#dropdown-notification').css('display') == 'none')
            {
                $.ajax({
                    type: "POST",
                    url: "/loadNotifications",
                    data: {},
                    cache: false,
                    beforeSend: function(){
                        $('.notificationContainers').html('<li><div class="loading-bar"><div></div></div></li>');
                    },
                    success: function(html) {
                        $("span.countNotifies").css('display', 'none');
                        $('.notificationContainers li').detach();
                        $('.notificationContainers').append(html);
                        updateTime();
                    }
                });
            }
        });
        /********** AMQP for friend requests *********/
        MQ.queue("userID<?php echo $loggedUserID; ?>").bind("dandelion", "friendRequests.*.<?php echo $loggedUserID; ?>").callback(function(m) {
            console.log('amqp data: ', m.data);

            $.ajax({
                type: "POST",
                url: "/notifications",
                data: {data: m.data, exchange: m.exchange, routingKey: m.routingKey},
                cache: false,
                success: function(html) {
                    $("span.countFriendRequest").css('display', 'block');
                    $("span.countFriendRequest").html(m.data.count);
                    updateTime();
                }
            });
        });
        $('body').on('click', '.friendRequests', function(){
            if($('#dropdown-friend').css('display') == 'none')
            {
                $.ajax({
                    type: "POST",
                    url: "/loadFriendRequests",
                    data: {},
                    cache: false,
                    beforeSend: function(){
                        $('.friendRqContainers').html('<li><div class="loading-bar"><div></div></div></li>');
                    },
                    success: function(html) {
                        $("span.countFriendRequest").css('display', 'none');
                        $('.friendRqContainers li').detach();
                        $('.friendRqContainers').append(html);
                        updateTime();
                    }
                });
            }
        });
    });
</script>
<div id="amqp-wrap" style="position:absolute;z-index:10000;">
    <div id="AMQPProxy"><!--Loading AMQP Proxy--></div>
</div>
<div class="ink-grid">
    <div class="column-group">
        <div class="large-80">
            <div class="large-20">
                <a href="/"><i class="topNavIcon1-logo"></i></a>
            </div>
            <div class="large-45" id="uiSearch">
                <div class="control-group">
                    <div class="control large-100 append-button ink-form column-group">
                        <input class="large-100" type="text" id="search" name="search" autocomplete="off">
                            <!--<div class="large-10"><a href="" class=""><i class="topNavIcon2-search"></i></a></div>-->
                    </div>
                </div>
                <div id="resultsHolder">
                    <ul id="resultsList">
                    </ul>
                </div>
            </div>
            <div class="large-5">
                <a class="float-right" href="/user/<?php echo $this->f3->get('SESSION.username'); ?>">
                    <img src="<?php echo $this->getAvatar($this->f3->get('SESSION.userID')) ?>" style="width: 30px; height: 30px">
                </a>
            </div>
            <div class="large-5">
                <a style="line-height: 30px; color: #fff; font-weight: bold; padding-left: 10px" href="/user/<?php echo $this->f3->get('SESSION.username'); ?>">
                    <?php echo $this->f3->get('SESSION.firstname'); ?>
                </a>
            </div>
            <div class="large-5">
                <a class="float-right" style="line-height: 30px; color: #fff; font-weight: bold" href="/home">Home</a>
            </div>
            <div class="large-5 friendRequests">
                <span class="ink-badge red countFriendRequest">0</span>
                <div class="float-right">
                    <?php $this->element('FriendRequestElement'); ?>
                </div>
            </div>
            <div class="large-5">
                <div class="float-right">
                    <?php $this->element('MessageElement'); ?>
                </div>
            </div>
            <div class="large-5 notifications">
                <span class="ink-badge red countNotifies">0</span>
                <div class="float-right">
                    <?php $this->element('NotificationElement'); ?>
                </div>
            </div>
            <div class="large-5">
                <div class="float-right">
                    <a data-dropdown="#dropdown-setting"><i class="icon20-privacy" style="margin-top: 7px"></i></a>
                    <div id="dropdown-setting" class="dropdown dropdown-tip dropdown-anchor-right" style="right: 303px;">
                        <ul class="dropdown-menu">
                            <li><a href="#">Account Setting</a></li>
                            <li><a href="#">Privacy Setting</a></li>
                            <li><a href="/logout">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
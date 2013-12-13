<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->f3->get('ENCODING'); ?>" />
    <title><?php echo $this->f3->get('site1'); ?></title>
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>reset.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>main.css" type="text/css" />
    <!--[if IE 7 ]>
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink-ie7.css" type="text/css" media="screen"
          title="no title">
    <![endif]-->
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/holder.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/autoload.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.autosize.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/blocksit.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.timers-1.2.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery.oembed.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/pretty.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/search.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/addFriend.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/follow.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/like.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/general.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.taPostStatus').autosize();
            $('.taPostComment').autosize();
            //target show popUp
            new showPopUpOver('a.postOption', '.uiPostOptionPopUpOver');
            new showPopUpOver('a.settingOption', '.uiSettingOptionPopUpOver');
            new showPopUpOver('a.quickPostStatusNav', '.uiQuickPostStatusPopUpOver');
            new showPopUpOver('a.showRequestFriends', '.uiFriendRequestsPopUpOver');
            new showPopUpOver('a.showMessages', '.uiMessagesPopUpOver');
            new showPopUpOver('a.showNotifications', '.uiNotificationsPopUpOver');
            $(document).click(function(){
                $('.uiPostOptionPopUpOver').hide();
                $('.uiSettingOptionPopUpOver').hide();
                $('.uiFriendRequestsPopUpOver').hide();
                $('.uiMessagesPopUpOver').hide();
                $('.uiNotificationsPopUpOver').hide();
            });
            $('.cancelPostStatusNavBtn').click(function(){
                $('.uiQuickPostStatusPopUpOver').hide();
                return false;
            });
            new LikeByElement('.likeSegments');
        });

        //layout photo like pinterest
        $(window).load( function() {
            $('.uiPhotoPinCol').BlocksIt({
                numOfCol: 3,
                offsetX: -5,
                offsetY: 5
            });
        });

        function showPopUpOver($click, $popUpOver) {
            $($click).click(function (){
                $($popUpOver).show();
                return false;
            });
        }
    </script>
    <script type="text/javascript">
        $(".autoloadModuleElement").ready(function()
        {
            $.ajax({
                type: "GET",
                url: "/pull",
                cache: false,
                success: function(html){
                    $(".autoloadModuleElement").html(html);
                    var lengthChild     = $('.autoloadModuleElement > div').length;
                    var actionArrays    = [];
                    var action;
                    for (var i=1;i <=lengthChild; i++)
                    {
                        action = $('.autoloadModuleElement > div:nth-child('+i+')').attr('class');
                        actionArrays.push(action);
                    }
                    //console.log(actionArrays);
                    $.ajax({
                        type: "POST",
                        url: "/loadSuggest",
                        data: {actionsName: actionArrays},
                        cache: false,
                        success: function(html){
                            $(".autoloadModuleElement").html(html);
                            //new IsActionsForSuggest();
                        }
                    })
                }
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".autoloadModuleElement").everyTime(60000,function(i){
                $.ajax({
                    type: "GET",
                    url: "/pull",
                    cache: false,
                    success: function(html){
                        $(".autoloadModuleElement").html(html);
                        var lengthChild     = $('.autoloadModuleElement > div').length;
                        var actionArrays    = [];
                        var action;
                        for (var i=1;i <=lengthChild; i++)
                        {
                            action = $('.autoloadModuleElement > div:nth-child('+i+')').attr('class');
                            actionArrays.push(action);
                        }
                        //console.log(actionArrays);
                        $.ajax({
                            type: "POST",
                            url: "/loadSuggest",
                            data: {actionsName: actionArrays},
                            cache: false,
                            success: function(html){
                                $(".autoloadModuleElement").html(html);
                                //new IsActionsForSuggest();
                            }
                        })
                    }
                })
            });

        });
    </script>
</head>
<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/3/13 - 3:08 PM
 * Project: joinShare Network - Version: 1.0
 */
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo F3::get('ENCODING');?>"/>
    <title><?php echo F3::get('SITE');?></title>

    <link rel="stylesheet" href="<?php echo F3::get('STATIC'); ?>css/reset.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo F3::get('STATIC'); ?>css/style.css" type="text/css" />
    <!-- Supports by jquery libs-->
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.autoSize-min.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.timers-1.0.0.js"></script>
    <!--Supports by social network libs-->
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/inputToggle.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/pretty.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/general.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/addFriend.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/follow.js"></script>
    <!--Supports for video embed task-->
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.oembed.min.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.oembed.js"></script>
    <!--Supports for display dialog when share status-->
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/fanc/jquery-ui-1.8.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo F3::get('STATIC'); ?>js/fanc/jquery-ui-1.8.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo F3::get('STATIC'); ?>js/fanc/jquery.ui.theme.css"/>
    <!--Association with amq-->
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/mq.js" ></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/swfobject.js" ></script>
    <?php
    //@TODO: check load css for each module
    foreach (glob(MODULES."*/webroot/css/*.css") as $cssPath){
        $cssFile= explode('modules',$cssPath,2);
        $cssMod = substr($cssFile[1],1); ?>
        <link type="text/css" rel="stylesheet" href="<?php echo F3::get('STATIC_MOD').$cssMod; ?>"/>
    <?php }   ?>
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
                    console.log(actionArrays);
                    $.ajax({
                        type: "POST",
                        url: "/loadSuggest",
                        data: {actionsName: actionArrays},
                        cache: false,
                        success: function(html){
                            $(".autoloadModuleElement").html(html);
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
                        console.log(actionArrays);
                        $.ajax({
                            type: "POST",
                            url: "/loadSuggest",
                            data: {actionsName: actionArrays},
                            cache: false,
                            success: function(html){
                                $(".autoloadModuleElement").html(html);
                            }
                        })
                    }
                })
            });

        });
    </script>
</head>
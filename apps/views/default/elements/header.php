<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/3/13 - 3:22 PM
 * Project: joinShare Network - Version: 1.0
 */
$ListRecordRequest       = F3::get('ListRecordRequestTo');
$ListPeopleRequestTo     = F3::get('ListPeopleRequestTo');
$ListRecordFollowTo      = F3::get('ListRecordFollowTo');
$ListPeopleFollowTo      = F3::get('ListPeopleFollowTo');
$useID                   = F3::get('queueAmq');
$allComment              = F3::get('allComment');
$countNotify             = F3::get('countNotify');
$currentUser            = F3::get('currentUser');

$currentUserName        = ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);
?>
<script type="text/javascript">

    MQ.on("connect", function() {
    });
    MQ.queue("socialhub<?php echo $useID; ?>").bind("socialhub<?php echo $useID; ?>", "socialhub<?php echo $useID; ?>").callback(function(m) {
        var commentID;
        var actiID;
        var content = m.data.value;
        var type = content.slice(0,1);
        var activity = content.slice(1,content.indexOf('-'));
        var currentID = $('#commentID0').val();
        console.log('currentID: ', currentID);
        if(currentID==null){
            commentID =0;
            actiID    = activity.slice(currentID.indexOf(':')+1);
        } else {
            commentID = currentID.slice(currentID.indexOf(':'));
            actiID    = activity.slice(currentID.indexOf(':'));
        }
        console.log('type in header: ', type);
        if(type == 2){ // 2 la comment
            $(document).ready(function(){
                var countNo = parseInt($(".numberNotify").val());
                var newValue = parseInt(countNo +1);
                $('.num').css({"display":"none"});
                $('<a href="" class="num">'+newValue+'</a>').appendTo('#navMsg');
                $('.numberNotify').val(newValue);
                $('#navMsg').removeClass('notifyDefault');
                $('#navMsg').addClass('notifyAction');
                //setCookie("notify",newValue,365);
            });
            if(actiID > commentID){
                $.ajax({
                    type: "POST",
                    url: "/notify",
                    cache: false,
                    success: function(html){
                        $("#containerNotify").prepend(html);
                    },
                    data: {activity_id:activity}
                });
            }
        }
    });
    $('#search').inputToggle({
        'inactive':'gray',
        'active':'black'
    });
</script>
<object type="application/x-shockwave-flash"
        data="<?php echo F3::get('STATIC')?>swfs/amqp.swf?0.3638039780780673"
        width="100%" height="1" id="AMQPProxy" style="visibility: visible;">
    <param name="allowScriptAccess" value="always">
    <param name="wmode" value="opaque">
    <param name="bgcolor" value="#96B669">
</object>
<div id="greenBarHolder" class="slim">
    <div id="greenBar" class="fix_elem">
        <div id="pageHead" class="clearfix slimHeader">
            <h1 id="page-logo">
                <a href="" title="Home Page"></a>
            </h1>
            <div id="headNav" class="clearfix">
                <div class="lfloat">
                    <form action="" method="get" name="navSearch" onsubmit=""
                          id="navSearch" class="headFocused">
                        <div class="searchHead">
                            <div class="wrap">
                                <div class="innerWrap">
									<span class="searchInput textInput">
                                        <span>
                                            <input type="text" class="inputtext DOMControl_placeholder"
                                                maxlength="100" name="search" id="search" value="Search"
                                                title="Search" onclick="" />
											<button type="submit" title="Search" onclick=""></button>
									    </span>
									</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="rfloat">
                    <ul id="pageNav">
                        <li class="topNavLink requestFriendDefault" id="navRequestFriend"><a href=""></a></li>
                        <div id="notifyRequestFriend" class="swFlyOut toggleTargetClosed positionRequestFriend">
                            <div class="flyoutArea">
                                <ul class="flyoutItemList">
                                    <div class="flyoutArea">
                                        <div class="flyoutHeader">Friend invitation</div>
                                        <?php
                                        // Show people request friendship to you
                                        if($ListRecordRequest) {
                                            foreach ($ListRecordRequest as $getRecordRequest) {
                                                $getIDRequest = $getRecordRequest->data->userA;
                                                foreach($ListPeopleRequestTo[$getIDRequest] as $People) {
                                                    $UserNameRequest = ucfirst($People->data->firstName).' '.ucfirst($People->data->lastName);
                                                    $peopleIDRequest = str_replace(':', '_', $People->recordID);
                                                    $avatar    =   $People->data->profilePic;
                                                    ?>
                                                    <ul class="flyoutItemList NewNotify" id="people-<?php echo $peopleIDRequest; ?>">
                                                        <form id="RequestOfID-<?php echo $peopleIDRequest; ?>">
                                                            <li class="notification">
                                                                <a class="notifyMainLink" href=""></a>
                                                                <div class="notifyBlock">
                                                                    <img class="notifyPhotoAuthor light" src="<?php echo $avatar; ?>" />
                                                                    <div class="notifyInfo">
                                                                        <div class="notifyText">
                                                                            <div class="name_time">
                                                                                <span class="blue Name"><?php echo $UserNameRequest; ?></span><br />
                                                                                <div class="notifyFooter swTimeComment" title="<?php echo $getRecordRequest->data->published; ?>"></div>
                                                                            </div>
                                                                            <span class="actionFriend">
                                                                                <a href="">
                                                                                    <img class="btnFi" id="acceptFriend" src="<?php echo F3::get('STATIC'); ?>images/agree.png"/>
                                                                                </a>
                                                                                <input type="hidden" id="PeopleID" name="id" value="<?php echo $peopleIDRequest;?>">
                                                                                <a  href="">
                                                                                    <img class="btnFi" id="cancelFriend" src="<?php echo F3::get('STATIC'); ?>images/cancel.png"/>
                                                                                </a>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </form>
                                                    </ul>
                                                <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </ul>
                            </div>
                            <div class="flyoutFooter">Show all requesting</div>
                        </div>
                        <li class="topNavLink msgDefault" id="navMessage">
                            <a href=""></a>
                        </li>
                        <?php
                        if($countNotify && $countNotify[0]->data->notify)
                        { ?>
                            <li class="topNavLink middleLink notifyAction" id="navMsg">
                                <a href="" class="num"><?php echo $countNotify[0]->data->notify ?></a>
                            </li>
                            <input class="numberNotify" value="<?php echo $countNotify[0]->data->notify ?>" type="hidden"/>
                        <?php
                        } else { ?>
                            <li class="topNavLink middleLink notifyDefault" id="navMsg"></li>
                            <input class="numberNotify" value="0" type="hidden"/>
                        <?php
                        } ?>
                        <div id="notifyContainer" class="swFlyOut toggleTargetClosed positionNotify">
                            <div class="flyoutArea">
                                <ul class="flyoutItemList">
                                    <div class="flyoutArea">
                                        <div class="flyoutHeader">Notifications</div>
                                        <div id="containerNotify">
                                            <?php
                                            // Show notify who comment to your post
                                            if($allComment)
                                            {
                                                foreach ($allComment as $key => $listComment)
                                                {
                                                    $actorName  = $listComment['name'];
                                                    $actorID    = $listComment['actor'];
                                                    $pfCommentActor = $listComment['pfCommentActor'];
                                                    $link       = $listComment['link'];
                                                    $content    = $listComment['content'];
                                                    $type       = $listComment['type'];
                                                    $text       = $listComment['text'];
                                                    $activityID = $listComment['activityID'];
                                                    $published  = $listComment['published'];
                                                    ?>
                                                    <ul  class="flyoutItemList NewNotify">
                                                        <li class="notification"><a class="notifyMainLink" href="/content/post/<?php echo $link; ?>">
                                                                <div class="notifyBlock">
                                                                    <input type="hidden" id="commentID<?php echo $key ?>" value="<?php echo $activityID; ?>" />
                                                                    <img class="notifyPhotoAuthor" src="<?php echo F3::get('BASE_URL'); ?><?php echo $pfCommentActor[$actorID]->data->profilePic; ?>" />
                                                                    <div class="notifyInfo">
                                                                        <div class="notifyText">
                                                                            <span class="blue Name"><?php echo $actorName; ?></span>
                                                                            <span class="label_text"> <?php echo $text." in ".$type; ?> </span>
                                                                        </div>
                                                                        <div id="contentNot"> <?php echo $content; ?></div>
                                                                    </div>
                                                                    <div class="notifyFooter swTimeComment" title="<?php echo $published;?>"></div>
                                                                </div>
                                                            </a></li>
                                                    </ul>
                                                <?php
                                                }
                                            }else { ?>
                                                <input type="hidden" id="commentID0" value="" />
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <div class="flyoutFooter">Show all notifications</div>
                        </div>

                        <li class="topNavLink middleLink" id="navHome">
                            <a href="/">Home</a>
                        </li>
                        <li class="topNavLink" id="navAccount">
                            <span class="headerName">
								<a href="/content/myPost"><?php echo $currentUserName;?></a>
						    </span>
                        </li>
                        <li class="menuDown topNavLink">
                            <a id="menuDownLink" href="#">
                                <div class="menuPullDown"></div>
                            </a> <!-- ul navigation (if exist) -->
                            <ul class="navPanel">
                                <li><a href="" class="navSubmenu" id ="settingAccount" >Account Settings</a></li>
                                <li><a href="" class="navSubmenu" >Privacy Settings</a></li>
                                <li>
                                    <form onsubmit="" action="/logout" method="post"
                                          id="logout_form">
                                        <input class="navSubmenu" type="submit" value="Log Out">
                                    </form>
                                </li>
                                <li class="menuDivider"></li>
                                <li><a href="" class="navSubmenu">Help</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script type="text/javascript">
                    //$(document).ready(function(){
                    //alert(111);
                    $("#menuDownLink").click(function() {
                        if ($(".navPanel").is(":hidden")){
                            $('.navPanel').show();
                        }
                        else{
                            $(".navPanel").hide();
                        }
                    })
                    //});
                </script>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $('#navMsg').live('click', function() {
        $('ul.NewNotify').removeClass('NewNotify');

    });

    $("#navRequestFriend").click(function(){
        $('#notifyRequestFriend').show();
        return false;
    });

    $("#navMsg").click(function(){

        $.ajax({
            type: "POST",
            url: "/updateNotification",
            cache: false
        });
        $('#notifyContainer').show();
        $('.num').remove();
        $('.numberNotify').val(0);

        return false;
    });
    $(document).click(function(){
        //with request friend
        $('#notifyRequestFriend').hide();
        $('#navRequestFriend').removeClass('requestFriendAction');
        $('#navRequestFriend').addClass('requestFriendDefault');
        //with notify
        $('#notifyContainer').hide();
        $('#navMsg').removeClass('notifyAction');
        $('#navMsg').addClass('notifyDefault');
    });

    $('#notifyContainer').click(function(e){
        e.stopPropagation();
    });
</script>
<div id="accountWrapper">

</div>
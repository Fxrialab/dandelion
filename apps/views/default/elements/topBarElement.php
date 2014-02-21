<?php
$currentUser            = $this->f3->get('currentUser');

$currentUserName        = ucfirst($currentUser->data->firstName);
?>
<div class="ink-grid">
    <div class="column-group fixMarginTopBottom-10">
        <div class="large-80">
            <div class="large-20">
                <a href="/"><i class="topNavIcon1-logo"></i></a>
            </div>
            <div class="large-5">
                <a href="/"><i class="topNavIcon1-home"></i></a>
            </div>
            <div class="large-40 fixMarginTop-4" id="uiSearch">
                <div class="control-group">
                    <div class="control large-100 append-button ink-form column-group">
                        <div class="large-80"><input class="large-100" type="text" id="search" name="search" autocomplete="off"></div>
                        <div class="large-10"><a href="" class=""><i class="topNavIcon2-search"></i></a></div>
                    </div>
                </div>
                <div id="resultsHolder">
                    <ul id="resultsList">
                    </ul>
                </div>
            </div>
            <div class="large-15">
                <div class="large-30 content-center uiFriendRequests">
                    <a href="" class="showRequestFriends"><i class="topNavIcon1-requestFriends"></i></a>
                    <div class="uiFriendRequestsPopUpOver uiBox-PopUp topRightCenterArrow">
                        <div class="titleHeaderPopUpOver">
                            Friend Requests
                        </div>
                        <div class="uiFriendRequestItems">
                            <ul>
                                <li class="rowItems column-group">
                                    <div class="profilePicDiv large-15">
                                        <img src="../webroot/images/avar.jpg">
                                    </div>
                                    <div class="profileInfoDiv large-45">
                                        <p><a class="timeLineLink large-100" href="">User 01</a></p>
                                        <span><a class="mutualLink large-100" href="">4 mutual friend</a></span>

                                    </div>
                                    <div class="actionDiv large-40">
                                        <a href="" class="uiSmallButton orange linkHover-fffff"><i></i>Add friend</a>
                                        <a href="" class="uiSmallButton orange linkHover-fffff"><i></i>Cancel</a>
                                    </div>
                                </li>
                                <li class="rowItems column-group">
                                    <div class="profilePicDiv large-15">
                                        <img src="../webroot/images/avar.jpg">
                                    </div>
                                    <div class="profileInfoDiv large-45">
                                        <p><a class="timeLineLink large-100" href="">User 02</a></p>
                                        <span><a class="mutualLink large-100" href="">2 mutual friend</a></span>

                                    </div>
                                    <div class="actionDiv large-40">
                                        <a href="" class="uiSmallButton orange linkHover-fffff"><i></i>Add friend</a>
                                        <a href="" class="uiSmallButton orange linkHover-fffff"><i></i>Cancel</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="uiSeeAllItems">
                            <a href="" class="seeAllLink">See All</a>
                        </div>
                    </div>
                </div>
                <div class="large-30 content-center uiMessages">
                    <a href="" class="showMessages"><i class="topNavIcon1-messages"></i></a>
                    <!--<div class="uiMessagesPopUpOver uiBox-PopUp topRightCenterArrow">
                        <div class="titleHeaderPopUpOver">
                            Inbox
                        </div>
                        <div class="uiMessageItems">
                            <ul>
                                <li class="rowItems column-group">
                                    <div class="profilePicDiv large-15">
                                        <img src="../webroot/images/avar.jpg">
                                    </div>
                                    <div class="profileInfoDiv large-80">
                                        <p><a class="timeLineLink large-100" href="">User 01</a></p>
                                        <span>hello guys</span>
                                        <p><a href="#" class="linkColor-999999" title="">37 minutes ago</a></p>
                                    </div>
                                </li>
                                <li class="rowItems column-group">
                                    <div class="profilePicDiv large-15">
                                        <img src="../webroot/images/avar.jpg">
                                    </div>
                                    <div class="profileInfoDiv large-80">
                                        <p><a class="timeLineLink large-100" href="">User 03</a></p>
                                        <span>good morning</span>
                                        <p><a href="#" class="linkColor-999999" title="">37 minutes ago</a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="uiSeeAllItems">
                            <a href="" class="seeAllLink">See All</a>
                        </div>
                    </div>-->
                </div>
                <div class="large-30 content-center uiNotifications">
                    <a href="" class="showNotifications"><i class="topNavIcon1-notifications"></i></a>
                    <!--<div class="uiNotificationsPopUpOver uiBox-PopUp topRightCenterArrow">
                        <div class="titleHeaderPopUpOver">
                            Notifications
                        </div>
                        <div class="uiNotificationItems">
                            <ul>
                                <li class="rowItems column-group">
                                    <div class="profilePicDiv large-15">
                                        <img src="../webroot/images/avar.jpg">
                                    </div>
                                    <div class="profileInfoDiv large-85">
                                        <p class="infoContent">
                                            <b class="timeLineLink fixColor-0069d6">User 01</b> likes your comment:
                                            <span>"look good"</span>
                                        </p>
                                        <span class="timePosted"><a href="#" class="linkColor-999999" title="">37 minutes ago</a></span>
                                    </div>
                                </li>
                                <li class="rowItems column-group">
                                    <div class="profilePicDiv large-15">
                                        <img src="../webroot/images/avar.jpg">
                                    </div>
                                    <div class="profileInfoDiv large-85">
                                        <p class="infoContent">
                                            <b class="timeLineLink fixColor-0069d6">User 04</b> posted in
                                            <b class="timeLineLink fixColor-0069d6">Marketing Online</b>
                                        </p>
                                        <span class="timePosted">
                                            <a href="#" class="linkColor-999999" title="">37 minutes ago</a>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="uiSeeAllItems">
                            <a href="" class="seeAllLink">See All</a>
                        </div>
                    </div>-->
                </div>
            </div>
            <div class="large-20">
                <div class="large-35 content-right uiStatusNav">
                    <a class="linkColor-9aa9c8 quickPostStatusNav large-100 column-group" href="">
                        <i class="topNavIcon2-quickWriteStatus large-40"></i>
                        <span class="large-60 fixMarginTop-13">Status</span>
                    </a>
                    <!--<div class="uiQuickPostStatusPopUpOver uiBox-PopUp topRightCenterArrow">
                        <form class="ink-form">
                            <fieldset>
                                <div class="control-group">
                                    <div class="control">
                                        <textarea class="taPostStatus" spellcheck="false" placeholder="What's on your mind?"></textarea>
                                    </div>
                                </div>
                                <div class="uiPostOption control-group">
                                    <nav class="ink-navigation">
                                        <ul class="menu horizontal">
                                            <li><a href="#" title="Choose a file to upload"><img src="<?php /*echo $this->f3->get('IMG'); */?>uploadPhotoIcon.png"></a></li>
                                            <li class="lineGapPostOption">|</li>
                                            <li><a href="#" title="Paste a video link"><img src="<?php /*echo $this->f3->get('IMG'); */?>uploadVideoIcon.png"></a></li>
                                            <li class="fixRightFloat">
                                                <span>
                                                    <a href="#" class="postStatusNavBtn uiSmallButton blue">Post</a>
                                                    <a href="#" class="cancelPostStatusNavBtn uiSmallButton blue">Cancel</a>
                                                </span>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </fieldset>
                        </form>
                    </div>-->
                </div>
                <div class="large-55 content-center fixMarginTop-12 uiTimeLineNav">
                    <a class="linkColor-9aa9c8" href="/content/myPost"><?php echo $currentUserName; ?></a>
                </div>
                <div class="large-10 uiSettingOptions content-right">
                    <a href="" class="settingOption"><i class="topNavIcon2-settingOptions"></i></a>
                    <div class="uiSettingOptionPopUpOver uiBox-PopUp topRightArrow">
                        <nav class="ink-navigation">
                            <ul class="menu vertical">
                                <li><a href="#">Account Setting</a></li>
                                <li><a href="#">Privacy Setting</a></li>
                                <li><a href="/logout">Log Out</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
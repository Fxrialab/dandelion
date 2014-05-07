<?php
$numberFriends = (!empty($friendsCurrentUser))?count($friendsCurrentUser):false;
?>
<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <div class="uiBoxTitle large-100 column-group">
            <div class="uiLeftPhotoBreadcrumbs large-50 medium-100 small-100">
                <nav class="ink-navigation">
                    <ul class="breadcrumbs">
                        <li><a href="#">Friends</a></li>
                        <li class="active"><a href="#">All Friends</a></li>
                    </ul>
                </nav>
            </div>
            <div class="uiRightPhotoTab large-50 medium-100 small-100">
                <nav class="ink-navigation">
                    <ul class="menu horizontal push-right">
                        <li>
                            <a href="" class="uiMediumButton white">All Friends
                                <?php
                                if (!empty($numberFriends))
                                {
                                    ?>
                                    <span class="ink-badge grey"><?php echo $numberFriends; ?></span>
                                <?php
                                }
                                ?>
                            </a>
                        </li>
                        <li><a href="" class="uiMediumButton white">Following</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="uiPhotoContainer uiBox-PopUp albumBoxArrow">
            <ul class="menu horizontal large-100 medium-100 small-100 uiFriendsWrapper">
                <?php
                if (!empty($friendsCurrentUser))
                {
                    foreach ($friendsCurrentUser as $friend)
                    {
                        $fullName   = ucfirst($infoFriends[$friend][0]->firstName)." ".ucfirst($infoFriends[$friend][0]->lastName);
                        $avatar     = $infoFriends[$friend][0]->profilePic;
                        $username   = $infoFriends[$friend][0]->username;
                        $statusFriendsShip = $friendsShip[$friend];
                        $rpFriendsID=  str_replace(':', '_', $friend);
                    ?>
                    <li class="large-50 medium-100 small-100">
                        <div class="friendItemWrapper column-group">
                            <a class="large-30 medium-60 small-100" href="">
                                <img src="<?php echo $avatar; ?>">
                            </a>
                            <div class="large-40 medium-80 small-100 infoFriends">
                                <p class="fontSize-14"><a href="/content/myPost?username=<?php echo $username; ?>"><?php echo $fullName; ?></a></p>
                                <?php
                                if (!empty($numberFriends))
                                {
                                    ?>
                                    <span><a class="fixcolor-adabab" href=""><?php echo $numberFriends; ?> friends</a></span>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="large-30 medium-60 small-100 actionFriends">
                                <?php
                                if ($statusFriendsShip == 'request' || $statusFriendsShip == 'later' || $statusFriendsShip == 'addFriend')
                                {
                                    if ($statusFriendsShip == 'request' || $statusFriendsShip == 'later')
                                    {
                                        ?>
                                        <a class="requestFriend uiSmallButton orange linkHover-fffff">Friend Request Sent</a>
                                        <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                                            <nav class="ink-navigation">
                                                <ul class="menu vertical">
                                                    <li><a>Report/Block</a></li>
                                                    <li><a class="cancelRequestFriend" id="<?php echo $rpFriendsID; ?>">Cancel Request</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                    <?php
                                    }else {
                                        if ($currentUser->recordID != $friend){
                                        ?>
                                        <a class="addFriend uiSmallButton orange linkHover-fffff" id="<?php echo $rpFriendsID; ?>">Add Friend</a>
                                    <?php
                                        }
                                    }
                                }elseif ($statusFriendsShip == 'respondRequest') {
                                    ?>
                                    <a class="respondFriendRequest uiSmallButton orange linkHover-fffff">Respond to Friend Request</a>
                                    <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                                        <nav class="ink-navigation">
                                            <ul class="menu vertical">
                                                <li><a class="confirmFriend" id="<?php echo $rpFriendsID; ?>">Confirm Friend</a></li>
                                                <li><a class="cancelRequestFriend" id="<?php echo $rpFriendsID; ?>">Unaccept Request</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                <?php
                                }else {
                                    ?>
                                    <a class="isFriend uiSmallButton orange linkHover-fffff">Friend</a>
                                    <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                                        <nav class="ink-navigation">
                                            <ul class="menu vertical">
                                                <li><a>Report/Block</a></li>
                                                <li><a class="cancelRequestFriend" id="<?php echo $rpFriendsID; ?>">Unfriend</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
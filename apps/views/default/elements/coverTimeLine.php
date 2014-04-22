<?php
$otherUser      = $this->f3->get('otherUser');
$currentUser    = $this->f3->get('currentUser');
$statusFriendShip   = $this->f3->get('statusFriendShip');
//prepare data
$otherUserID    = $otherUser->recordID;
$currentUserID  = $currentUser->recordID;
$otherUserName  = ucfirst($otherUser->data->firstName)." ".ucfirst($otherUser->data->lastName);
$currentUserName= ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);

if($otherUserID != $currentUserID)
{
    $rpOtherUserID  = str_replace(':', '_', $otherUserID);
?>
    <div class="uiCoverTimeLineContainer">
        <div class="uiCoverTimeLine">
            <div class="imageCoverTimeLine">
                <a href=""><img src="<?php echo $this->f3->get('IMG');?>testImage.jpg"></a>
            </div>
            <div class="editCoverTimeLine">
                <a href="" class="uiMediumButton"><i class="customIcon-editAvatar"></i>Change Cover</a>
            </div>
        </div>
        <div class="uiTimeLineNav">
            <div class="uiProfilePicTimeLine">
                <div class="profilePic">
                    <a href=""><img src="<?php echo $otherUser->data->profilePic; ?>"></a>
                </div>
                <div class="editProfilePic">
                    <a href="" class="uiMediumButton"><i class="customIcon-editAvatar"></i>Edit Avatar</a>
                </div>
            </div>
            <div class="timeLineMenuNav column-right">
                <nav class="ink-navigation uiTimeLineHeadLine">
                    <ul class="menu horizontal">
                        <li><a href="/content/myPost">TimeLine</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/friends">Friends</a></li>
                        <li><a href="/content/myPhoto">Photos</a></li>
                        <li><a href="#">More</a></li>
                    </ul>
                </nav>
            </div>
            <div class="uiProfileInfoTimeLine column-group">
                <div class="profileInfoDiv large-50">
                    <p class="profileName"><a class="tlProfileLink large-100" href=""><?php echo $otherUserName; ?></a></p>
                    <div class="uiActionUser">
                        <?php
                        if ($statusFriendShip == 'request' || $statusFriendShip == 'later' || $statusFriendShip == 'addFriend')
                        {
                            if ($statusFriendShip == 'request' || $statusFriendShip == 'later')
                            {
                                ?>
                                <a class="requestFriend uiMediumButton orange linkHover-fffff">Friend Request Sent</a>
                                <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                                    <nav class="ink-navigation">
                                        <ul class="menu vertical">
                                            <li><a>Report/Block</a></li>
                                            <li><a class="cancelRequestFriend" id="<?php echo $rpOtherUserID; ?>">Cancel Request</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            <?php
                            }else {
                                ?>
                                <a class="addFriend uiMediumButton orange linkHover-fffff" id="<?php echo $rpOtherUserID; ?>">Add Friend</a>
                            <?php
                            }
                        }elseif ($statusFriendShip == 'respondRequest') {
                            ?>
                            <a class="respondFriendRequest uiMediumButton orange linkHover-fffff">Respond to Friend Request</a>
                            <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                                <nav class="ink-navigation">
                                    <ul class="menu vertical">
                                        <li><a class="confirmFriend" id="<?php echo $rpOtherUserID; ?>">Confirm Friend</a></li>
                                        <li><a class="cancelRequestFriend" id="<?php echo $rpOtherUserID; ?>">Unaccept Request</a></li>
                                    </ul>
                                </nav>
                            </div>
                        <?php
                        }else {
                            ?>
                            <a class="isFriend uiMediumButton orange linkHover-fffff">Friend</a>
                            <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
                                <nav class="ink-navigation">
                                    <ul class="menu vertical">
                                        <li><a>Report/Block</a></li>
                                        <li><a class="cancelRequestFriend" id="<?php echo $rpOtherUserID; ?>">Unfriend</a></li>
                                    </ul>
                                </nav>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="viewBox large-50 push-right">
                    <div class="friendsBox">
                        <div class="uiImageBox">
                            <div class="column-group firstRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                            <div class="column-group secondRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                        </div>
                        <div class="uiTargetBox">Friends (213)</div>
                    </div>
                    <div class="photosBox">
                        <div class="uiImageBox">
                            <div class="column-group firstRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                            <div class="column-group secondRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                        </div>
                        <div class="uiTargetBox">Photos (103)</div>
                    </div>
                    <div class="groupsBox">
                        <div class="uiImageBox">
                            <div class="column-group firstRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                            <div class="column-group secondRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                        </div>
                        <div class="uiTargetBox">Groups (17)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}else {
?>
    <div class="uiCoverTimeLineContainer">
        <div class="uiCoverTimeLine">
            <div class="imageCoverTimeLine">
                <a href=""><img src="<?php echo $this->f3->get('IMG');?>testImage.jpg"></a>
            </div>
            <div class="editCoverTimeLine">
                <a href="" class="uiMediumButton"><i class="customIcon-editAvatar"></i>Change Cover</a>
            </div>
        </div>
        <div class="uiTimeLineNav">
            <div class="uiProfilePicTimeLine">
                <div class="profilePic">
                    <a href=""><img src="<?php echo $currentUser->data->profilePic;?>"></a>
                </div>
                <div class="editProfilePic">
                    <a href="" class="uiMediumButton"><i class="customIcon-editAvatar"></i>Edit Avatar</a>
                </div>
            </div>
            <div class="timeLineMenuNav column-right">
                <nav class="ink-navigation uiTimeLineHeadLine">
                    <ul class="menu horizontal">
                        <li><a href="/content/myPost">TimeLine</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/friends">Friends</a></li>
                        <li><a href="/content/myPhoto">Photos</a></li>
                        <li><a href="#">More</a></li>
                    </ul>
                </nav>
            </div>
            <div class="uiProfileInfoTimeLine column-group">
                <div class="profileInfoDiv large-50">
                    <p class="profileName"><a class="tlProfileLink large-100" href=""><?php echo $currentUserName;?></a></p>
                    <a href="" class="uiMediumButton orange linkHover-fffff"><i></i>Update Info</a>
                </div>
                <div class="viewBox large-50 push-right">
                    <div class="friendsBox">
                        <div class="uiImageBox">
                            <div class="column-group firstRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                            <div class="column-group secondRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                        </div>
                        <div class="uiTargetBox">Friends (213)</div>
                    </div>
                    <div class="photosBox">
                        <div class="uiImageBox">
                            <div class="column-group firstRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                            <div class="column-group secondRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                        </div>
                        <div class="uiTargetBox">Photos (103)</div>
                    </div>
                    <div class="groupsBox">
                        <div class="uiImageBox">
                            <div class="column-group firstRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                            <div class="column-group secondRow">
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                                <div class="large-50"><a href=""><img src="<?php echo $this->f3->get('IMG');?>avar.jpg"></a></div>
                            </div>
                        </div>
                        <div class="uiTargetBox">Groups (17)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
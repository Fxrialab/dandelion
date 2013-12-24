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
    $rpOtherUserID  = substr($otherUserID, strpos($otherUserID, ':') + 1);
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
                    <?php
                    if ($statusFriendShip == 'request' || $statusFriendShip == 'null'){
                    ?>
                        <form id="friendID">
                            <input type="hidden" value="<?php echo $rpOtherUserID; ?>" name="id">
                            <input type="hidden" id="status_fr" value="<?php echo $statusFriendShip; ?>" name="status_fr">
                            <button class="addFriend uiMediumButton orange linkHover-fffff" type="submit"></button>
                        </form>
                    <?php
                    }else {
                    ?>
                        <form id="friendID">
                            <input type="hidden" value="<?php echo $rpOtherUserID; ?>" name="id">
                            <input type="hidden" id="status_fr" value="<?php echo $statusFriendShip; ?>" name="status_fr">
                            <button class="friend uiMediumButton orange linkHover-fffff" type="submit">Friend</button>
                        </form>
                    <?php
                    }
                    ?>
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
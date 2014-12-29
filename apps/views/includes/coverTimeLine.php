<?php
$currentProfile = $this->f3->get('SESSION.loggedUser');
$otherUser = $this->f3->get('otherUser');
$currentUser = $this->f3->get('currentUser');
$statusFriendShip = $this->f3->get('statusFriendShip');
//prepare data
$otherUserID = $otherUser->recordID;
$otherUserName = ucfirst($otherUser->data->firstName) . " " . ucfirst($otherUser->data->lastName);

$rpOtherUserID = str_replace(':', '_', $otherUser->recordID);
?>

<div class="uiCoverTimeLineContainer" style=" position: relative">

    <?php
    $a = 'Add a cover';
    ?>
    <form id="submitCover">
        <div class="column-group uiCoverTimeLine">

            <div class="uploadCoverStatusBar"></div>
            <div class="displayPhoto">
                <?php
                if (!empty($otherUser->data->coverPhoto))
                {
                    ?>
                    <div class="imgCover">
                        <div style=" position: relative; left: -6px; top: -36px ">
                            <a class="popupPhoto" href="/content/photo/index?uid=<?php echo $this->getId($otherUser->recordID) . '&sid=0&pid=' . $this->getId($otherUser->data->coverPhoto) . '&page=0' ?>">
                                <img src="<?php echo $this->getImg($otherUser->data->coverPhoto) ?>" style="width:100%;">
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="actionCover">
                <a data-dropdown="#dropdown-uploadCover" class=" add" style="color:#000"><i class="fa fa-camera fa-24" ></i></a>
                <div id="dropdown-uploadCover" class="dropdown dropdown-tip">
                    <ul class="dropdown-menu">
                        <li><a href="/photoBrowser?profile_id=<?php echo $currentUser->recordID ?>&photo_id=<?php echo $currentUser->recordID ?>&type=cover" class="popupMyPhoto"  title="Choose From My Photos"><i class="fa fa-image"></i>Choose from Photos...</a></li>
                        <li><a id="uploadCover"><i class="fa fa-upload"></i>Upload photo</a></li>
                        <?php
                        if (!empty($otherUser->data->coverPhoto) && $otherUser->data->coverPhoto != 'none')
                        {
                            ?>
                            <li><a href="javascript:void(0)" id="removeCover" title="Remove"><i class="fa fa-remove"></i>Remove</a></li>
                        <?php } ?>
                    </ul>

                </div>
            </div>

        </div>
        <div class="timeLineMenuNav ">
            <div class="nav">
                <?php
                $username = $otherUser->data->username;
                $f3 = require('navTimeLine.php');
                ?>
            </div>
        </div>
    </form>
    <div id="imgAvatar" style=" position: relative;">
        <div class="uploadAvatarStatusBar"></div>
        <div class="profilePic">
            <?php
//                    if ($otherUser->data->profilePic != 'none')
//                    {
//                        $labelStt = 'Change avatar';
//                        $photoID = str_replace(':', '_', $photo->recordID);
//                    }
//                    else
//                    {
            $labelStt = 'Add avatar';
            $viewAvatar = '';
//                    }
            ?>
            <a class="infoUser page" >
                <div class="profilePicThumb">
                    <div class="profilePicThumbImg">
                        <a class="popupPhoto" href="/content/photo/index?uid=<?php echo $this->getId($otherUser->recordID) . '&sid=0&pid=' . $this->getId($otherUser->data->profilePic) . '&page=0' ?>">
                            <img src="<?php echo $this->getAvatar($otherUser->data->profilePic); ?>">
                        </a>
                    </div>
                </div>
            </a>
        </div>
        <?php
        if ($currentUser->recordID == $otherUser->recordID)
        {
            $uni = uniqid();
            ?>
            <div class="profileInfo">
                <a data-dropdown="#dropdown_<?php echo $uni ?>"><i class="fa fa-camera fa-24 fa-white" ></i></a>
                <div id="dropdown_<?php echo $uni ?>" class="dropdown dropdown-tip">
                    <ul class="dropdown-menu">
                        <li><a href="/photoBrowser?profile_id=<?php echo $currentUser->recordID ?>&photo_id=<?php echo $currentUser->recordID ?>&type=avatar" class="popupMyPhoto"  title="Choose From My Photos"><i class="fa fa-image"></i>Choose from Photos...</a></li>
                        <li><a id="uploadAvatar"><i class="fa fa-upload"></i>Upload photo</a></li>
                        <?php
                        if ($otherUser->data->profilePic != 'none')
                        {
                            ?>
                            <li><a href="#" class="removeImgUser" id="removeAvatar" role="avatar" title="Remove"><i class="fa fa-remove"></i>Remove</a></li>
                        <?php } ?>
                    </ul>

                </div>
            </div>
        <?php } ?>
    </div>
    <a class="name" href="#"><?php echo $otherUserName; ?></a>

    <div class="uiProfilePicTimeLine imgAvatar">

        <div class="firendRequest profileInfoDiv">
            <div class="uiActionUser">
                <?php
                if ($statusFriendShip == 'request' || $statusFriendShip == 'later' || $statusFriendShip == 'addFriend')
                {
                    if ($statusFriendShip == 'request' || $statusFriendShip == 'later')
                    {
                        ?>
                        <a data-dropdown="#dropdown-requestFriend" class="requestFriend button blue"><span>Friend Request Sent</span></a>
                        <div id="dropdown-requestFriend" class="dropdown dropdown-tip">
                            <ul class="dropdown-menu">
                                <li><a>Report/Block</a></li>
                                <li><a class="cancelRequestFriend" id="<?php echo $rpOtherUserID; ?>">Cancel Request</a></li>
                            </ul>
                        </div>
                        <?php
                    } else
                    {
                        ?>
                        <a class="addFriend button blue linkHover-fffff" id="<?php echo $rpOtherUserID; ?>">Add Friend</a>
                        <?php
                    }
                } elseif ($statusFriendShip == 'respondRequest')
                {
                    ?>
                    <a data-dropdown="#dropdown-respondFriendRequest" class="respondFriendRequest button blue"><span>Respond to Friend Request</span></a>
                    <div id="dropdown-respondFriendRequest" class="dropdown dropdown-tip">
                        <ul class="dropdown-menu">
                            <li><a class="confirmFriend" id="<?php echo $rpOtherUserID; ?>">Confirm Friend</a></li>
                            <li><a class="cancelRequestFriend" id="<?php echo $rpOtherUserID; ?>">Unaccept Request</a></li>
                        </ul>
                    </div>
                    <?php
                } elseif ($statusFriendShip == 'updateInfo')
                {
                    ?>
                    <a class="button blue linkHover-fffff" href="/about?user=<?php echo $currentUser->data->username; ?>&section=overview">Update Info</a>
                    <?php
                } else
                {
                    ?>
                    <div class="friendButton">
                        <div>
                            <a data-dropdown="#dropdown-isFriend" class="button blue"><span>Friend</span></a>
                            <div id="dropdown-isFriend" class="dropdown dropdown-tip">
                                <ul class="dropdown-menu">
                                    <li><a>Report/Block</a></li>
                                    <li><a class="cancelRequestFriend" id="<?php echo $rpOtherUserID; ?>">Unfriend</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>

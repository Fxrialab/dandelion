<?php
$otherUser = $this->f3->get('otherUser');
$currentUser = $this->f3->get('currentUser');
$statusFriendShip = $this->f3->get('statusFriendShip');
//prepare data
$otherUserID = $otherUser->recordID;
$currentUserID = $currentUser->recordID;
$otherUserName = ucfirst($otherUser->data->firstName) . " " . ucfirst($otherUser->data->lastName);
$currentUserName = ucfirst($currentUser->data->firstName) . " " . ucfirst($currentUser->data->lastName);

$rpOtherUserID = str_replace(':', '_', $otherUserID);
?>
<div class="uiCoverTimeLineContainer">
    <form id="submitCover">
        <?php
        if (!empty($otherUser->data->urlCover))
        {
            $a = 'Edit a cover';
            $style = 'height:250px; background-image: url(' . $otherUser->data->urlCover . ')';
        }
        else
        {
            $style = '';
            $a = 'Add a cover';
        }
        ?>
        <div class="column-group uiCoverTimeLine displayPhoto" style="position: relative">
            <div style="<?php echo $style ?>">
                <div  style=" position: absolute; top: 10px; right: 10px">
                    <div class="dropdown">
                        <a href="#" class="button"><span class="icon icon148"></span><span class="label"><?php echo $a ?></span></a>
                        <div class="dropdown-slider w175">
                            <a href="#" class="photoBrowse ddm" title="My Photos"><span class="icon icon147"></span><span class="label">Choose from Photos...</span></a>
                            <a href="#" class="ddm"><div id="uploadPhotoCover"><span class="icon icon189"></span><span class="label">Upload photo</span></div></a>
                            <?php
                            if (!empty($otherUser->data->urlCover))
                            {
                                ?>
                                <a class="removercover ddm" role="remove" title="Remove"><span class="icon icon58"></span><span class="label">Remove</span></a>
                            <?php } ?>
                        </div> <!-- /.dropdown-slider -->
                    </div> <!-- /.dropdown -->
                </div>
            </div>
            <div class="timeLineMenuNav float-right">
                <?php
                $username = $otherUser->data->username;
                $f3 = require('navTimeLine.php');
                ?>
            </div>
        </div>
    </form>
    <div class="uiProfilePicTimeLine imgAvatar">
        <div id="imgAvatar">
            <div class="profilePic">
                <a href=""><img src="<?php echo $otherUser->data->profilePic; ?>"></a>
                <div class="profileInfo" >
                    <div class="dropdown">
                        <a href="#" class="button"><span class="icon icon148"></span><span class="label">Update Avatar</span></a>
                        <div class="dropdown-slider left w175">
                            <a href="#" class="photoBrowse ddm" role="avatar" title="My Photos"><span class="icon icon147"></span><span class="label">Choose from Photos...</span></a>
                            <a href="#" class="ddm"><div id="uploadAvatar"><span class="icon icon189"></span><span class="label">Upload photo</span></div></a>
                            <a href="#" class="ddm"><span class="icon icon58"></span><span class="label">Remove</span></a>
                        </div> <!-- /.dropdown-slider -->
                    </div> <!-- /.dropdown -->
                </div>
            </div>
        </div>
        <a class="name" href="#"><?php echo $otherUserName; ?></a>
        <div class="firendRequest profileInfoDiv">
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
                    }
                    else
                    {
                        ?>
                        <a class="addFriend uiMediumButton orange linkHover-fffff" id="<?php echo $rpOtherUserID; ?>">Add Friend</a>
                        <?php
                    }
                }
                elseif ($statusFriendShip == 'respondRequest')
                {
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
                }
                else
                {
                    ?>
                    <a class="isFriend uiMediumButton orange linkHover-fffff ink-button">Friend</a>
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
    </div>

</div>

<script>
    $(function() {

        $("#submitCover").submit(function() {
            $.ajax({
                type: "POST",
                url: "/comfirmphoto",
                data: $("#submitCover").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $('.dropdown-editcover').remove();
                    $('.timeLineMenuNav').html(data);
                    $('.editdropdown').css('display', 'block');
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    })

</script>

<script id="comfirmTemplate" type="text/x-jQuery-tmpl">
    <div class="control-group">
    <div class="control">
    <div class="statusDialog">Are you sure you want to remove </div>
    </div>
    </div>
    <input type="hidden" id="role" name="role" value="${role}">
    <div class="footerDialog" >
    <button type="submit" class="ink-button green-button comfirmCover">Comfirm</button>
    <button class=" closeDialog ink-button ">Cancel</a>
    </div>
</script>
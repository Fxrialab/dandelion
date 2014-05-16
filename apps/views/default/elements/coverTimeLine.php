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
            $style = 'height:250px; background-image: url(' . $otherUser->data->urlCover . ')';
            $a = 'Edit a cover';
        }
        else
        {
            $style = '';
            $a = 'Add a cover';
        }
        ?>
        <div class="column-group uiCoverTimeLine displayPhoto">
            <div style="<?php echo $style ?>">
                <div class="large-85"></div>
                <div class="large-15 dropdown-editcover float-right">
                    <a href="#" class="ink-button edit" data-dropdown="#dropdown-editcover"><?php echo $a ?></a>
                    <div id="dropdown-editcover" class="dropdown dropdown-notip dropdown-anchor-right">
                        <ul class="dropdown-menu">
                            <li><a href="#" class="photoBrowse" title="My Photos">Choose from My Photos</a></li>
                            <li><a id="uploadPhotoCover">Upload Photo</a></li>
                            <?php
                            if (!empty($otherUser->data->urlCover))
                            {
                                ?>
                                <li><a class="removercover" role="remove" title="Remove">Remove</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="uiTimeLineNav">
            <div class="uiProfilePicTimeLine">
                <div class="profilePic">
                    <a href=""><img src="<?php echo $otherUser->data->profilePic; ?>"></a>
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
            <div class="timeLineMenuNav float-right">
                <?php
                $username = $otherUser->data->username;
                $f3 = require('navTimeLine.php');
                ?>
            </div>

        </div>
    </form>
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
//        $('form').live('submit', '#formRemoveCover', function() {
//            $.ajax({
//                type: "POST",
//                url: "/comfirmphoto",
//                data: $("#formRemoveCover").serialize(), // serializes the form's elements.
//                success: function(data)
//                {
//                    $('.dropdown-editcover').remove();
//                    $('.timeLineMenuNav').html(data);
//                    $('.editdropdown').css('display', 'block');
//                }
//            });
//
//            return false;
//        })
//        $("#formRemoveCover").submit(function() {
//            $.ajax({
//                type: "POST",
//                url: "/comfirmphoto",
//                data: $("#formRemoveCover").serialize(), // serializes the form's elements.
//                success: function(data)
//                {
//                    $('.dropdown-editcover').remove();
//                    $('.timeLineMenuNav').html(data);
//                    $('.editdropdown').css('display', 'block');
//                }
//            });
//
//            return false; // avoid to execute the actual submit of the form.
//        });
    });
    // Create an array of books

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
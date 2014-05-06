<?php
if (!empty($requestFriend))
{
    ?>
    <a class="requestFriend uiMediumButton orange linkHover-fffff">Friend Request Sent</a>
    <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
        <nav class="ink-navigation">
            <ul class="menu vertical">
                <li><a>Report/Block</a></li>
                <li><a class="cancelRequestFriend" id="<?php echo $toUser; ?>">Cancel Request</a></li>
            </ul>
        </nav>
    </div>
<?php
}
if (!empty($addFriend))
{
    ?>
    <a class="addFriend uiMediumButton orange linkHover-fffff" id="<?php echo $toUser; ?>">Add Friend</a>
<?php
}
if (!empty($isFriend))
{
    ?>
    <a class="isFriend uiMediumButton orange linkHover-fffff">Friend</a>
    <div class="uiFriendOptionPopUpOver uiBox-PopUp topCenterArrow infoOver-">
        <nav class="ink-navigation">
            <ul class="menu vertical">
                <li><a>Report/Block</a></li>
                <li><a class="cancelRequestFriend" id="<?php echo $toUser; ?>">Unfriend</a></li>
            </ul>
        </nav>
    </div>
<?php
}?>
<?php
if (!empty($requestFriend))
{
    ?>
    <a data-dropdown="#dropdown-requestFriend" class="requestFriend button blue"><span>Friend Request Sent</span></a>
    <div id="dropdown-requestFriend" class="dropdown dropdown-tip">
        <ul class="dropdown-menu">
            <li><a>Report/Block</a></li>
            <li><a class="cancelRequestFriend" id="<?php echo $toUser; ?>">Cancel Request</a></li>
        </ul>
    </div>
<?php
}
if (!empty($addFriend))
{
    ?>
    <a class="addFriend button blue linkHover-fffff" id="<?php echo $toUser; ?>">Add Friend</a>
<?php
}
if (!empty($isFriend))
{
    ?>
    <a data-dropdown="#dropdown-isFriend" class="button blue"><span>Friend</span></a>
    <div id="dropdown-isFriend" class="dropdown dropdown-tip">
        <ul class="dropdown-menu">
            <li><a>Report/Block</a></li>
            <li><a class="cancelRequestFriend" id="<?php echo $toUser; ?>">Unfriend</a></li>
        </ul>
    </div>
<?php
}?>
<?php
$avatar     = HelperController::getAvatar($friends);
$fullName   = HelperController::getFullNameUser($friends->recordID);
$friendID   = str_replace(':','_',$friends->recordID);
?>
<div class="large-50 uiBoxFriends">
    <div class="friendContainers">
        <img src="<?php echo $avatar; ?>">
        <a class="friendName" href="/content/post?user=<?php echo $friends->data->username; ?>"><?php echo $fullName; ?></a>
        <span style="position: absolute; top: 50px; left: 110px;">123 friends</span>

        <div style="position: absolute; top: 35px; right: 10px; margin: 0;">
            <div class="friendButton">
                <div>
                    <a data-dropdown="#dropdown-isFriends" class="button blue icon approve"><span>Friends</span></a>
                    <div id="dropdown-isFriends" class="dropdown dropdown-tip">
                        <ul class="dropdown-menu">
                            <li><a href="#">Get Notifications</a></li>
                            <li><a class="cancelRequestFriend" id="<?php echo $friendID; ?>">Unfriend</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$friends = $this->f3->get('friends');
foreach ($friends as $value)
{
    $friend = $value['friend'];
    ?>
    <div class="large-50 uiBoxFriends">
        <div class="friendContainers">
            <img src="<?php echo $this->getAvatar($friend->data->profilePic)?>">
            <a class="friendName" href="/content/post?user=<?php echo $friend->data->username; ?>"><?php echo $friend->data->fullName; ?></a>
            <span style="position: absolute; top: 50px; left: 110px;">123 friends</span>

            <div style="position: absolute; top: 35px; right: 10px; margin: 0;">
                <div class="friendButton">
                    <div>
                        <a data-dropdown="#dropdown-isFriends" class="button"><i class="fa fa-check"></i><span>Friends</span></a>
                        <div id="dropdown-isFriends" class="dropdown dropdown-tip">
                            <ul class="dropdown-menu">
                                <li><a href="#">Get Notifications</a></li>
                                <li><a class="cancelRequestFriend" id="<?php echo $friend->recordID; ?>">Unfriend</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
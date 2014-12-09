<?php
$otherUser = $this->f3->get('SESSION.loggedUser');
$userID = $this->f3->get('SESSION.userID');
?>
<div class="uiLeftCol large-20">
    <div class="uiBoxProfile column-group">
        <div class="uiProfilePic large-30"><a href="/about?user=<?php echo $otherUser->data->username; ?>&section=overview">
                <img src="<?php echo $this->getAvatar($otherUser->data->profilePic); ?>" width="50" height="50"></a></div>
        <div class="uiProfileInfo large-70">
            <div class="profileName"><a href="/about?user=<?php echo $otherUser->data->username ?>&section=overview"><?php echo $otherUser->data->fullName ?></a></div>
            <?php
            if ($otherUser->recordID == $userID)
                echo ' <div><a href="/about?user=' . $otherUser->data->username . '&section=overview">Edit Profile</a></div>';
            ?>

        </div>
    </div>
    <div class="column-group">
        <nav class="ink-navigation">
            <ul class="menu sideNav">
                <li><a href=""><i class="fa fa-files-o fa-16"></i> New Feed</a></li>
                <li><a href=""><i class="fa fa-envelope fa-16"></i> Messages</a></li>
                <li><a href=""><i class="fa fa-calendar fa-16"></i> Event</a></li>
            </ul>

            <?php
            $this->element('GroupElement');
            ?>

            <ul class="menu sideNav">
                <li><h6>DEVELOPERS</h6></li>
            </ul>
            <ul class="menu sideNav">
                <li><h6>EVENT</h6></li>
                    <li><a ><i class="fa fa-plus-square fa-14"></i> Greate Event</a></li>
            </ul>
        </nav>
      
    </div>
</div>
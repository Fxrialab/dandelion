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
    <div class="uiSideNav column-group">
        <nav class="uiVerticalNav">
            <ul class="uiVerticalNav-menu">
                <li>
                    <a href="#" class="uiVerticalNav-item">
                        <i class="icon30-newFeed"></i>
                        News Feed
                        <span class="uiVerticalNav-counter">4</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="uiVerticalNav-item">
                        <i class="icon30-message"></i>
                        Messages
                        <span class="uiVerticalNav-counter">8</span>
                    </a>
                </li>
                <li class="">
                    <a href="/content/group?category=membership" class="uiVerticalNav-item">
                        <i class="icon30-group"></i>
                        Group
                        <span class="uiVerticalNav-counter"><?php echo HelperController::countGroup() ?></span>
                    </a>
                    <ul class="uiVerticalNav-menu">
                        <li class="active children"><a href="/content/group?category=admin"><i class="icon30-index"></i>Groups your Admin</a></li>
                        <?php
                        $memberGroup = HelperController::groupMember();
                        if (!empty($memberGroup))
                        {
                            foreach ($memberGroup as $value)
                            {
                                $group = HelperController::findGroup($value->data->groupID);
                                if (!empty($group))
                                {
                                    ?>
                                    <li class="children"><a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><i class="icon30-index"></i><?php echo $group->data->name ?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <!--<li class="active"><a href="/content/group/addGroup">Create Group</a></li>-->
                        <!--<li><a href="">Vacation <span class="uiVerticalNav-counter">23</span></a></li>-->
                    </ul>
                </li>
                <li>
                    <a href="#" class="uiVerticalNav-item">
                        <i class="icon30-event"></i>
                        Event
                        <span class="uiVerticalNav-counter">42</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
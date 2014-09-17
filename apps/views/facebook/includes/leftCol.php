<div class="uiLeftCol large-20">
    <div class="uiBoxProfile column-group">
        <div class="uiProfilePic large-30"><a href="/content/post?user=<?php echo $this->f3->get('SESSION.username'); ?>">
                <img src="<?php echo $this->f3->get('SESSION.avatar'); ?>" width="50" height="50"></a></div>
        <div class="uiProfileInfo large-70">
            <p class="fixMarginBottom-5"><a href="/content/post?user=<?php echo $this->f3->get('SESSION.username'); ?>"><?php echo $this->f3->get('SESSION.fullname'); ?></a></p>
            <span><a href="/content/post?user=<?php echo $this->f3->get('SESSION.username'); ?>">Edit Profile</a></span>
        </div>
    </div>
    <div class="uiSideNav column-group">
        <nav class="uiVerticalNav">
            <ul class="uiVerticalNav-menu">
                <li class="active">
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
                        <span class="uiVerticalNav-counter">15</span>
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
                                    <li><a href="/content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>"><?php echo $group->data->name ?></a></li>
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
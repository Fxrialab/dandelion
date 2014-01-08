<?php
$currentUser        = $this->f3->get('currentUser');

$currentProfilePic  = $currentUser->data->profilePic;
$currentUserName    = ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);
?>
<div class="uiLeftCol large-20">
    <div class="uiBoxProfile column-group">
        <div class="uiProfilePic large-30"><a href=""><img src="<?php echo $currentProfilePic; ?>" width="50" height="50"></a></div>
        <div class="uiProfileInfo large-70">
            <p class="fixMarginBottom-5"><a href=""><?php echo $currentUserName; ?></a></p>
            <span><a href="">Edit Profile</a></span>
        </div>
    </div>
    <div class="uiSideNav column-group">
        <nav class="uiVerticalNav">
            <ul class="uiVerticalNav-menu">
                <li class="active">
                    <a href="#" class="uiVerticalNav-item">
                        <i class="navMenuIcon-newFeed"></i>
                        News Feed
                        <span class="uiVerticalNav-counter">4</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="uiVerticalNav-item">
                        <i class="navMenuIcon-messages"></i>
                        Messages
                        <span class="uiVerticalNav-counter">8</span>
                    </a>
                </li>
                <li class="">
                    <a href="#" class="uiVerticalNav-item">
                        <i class="navMenuIcon-group"></i>
                        Group
                        <span class="uiVerticalNav-counter">15</span>
                    </a>
                    <ul class="uiVerticalNav-subnav">
                        <li class="active"><a href="">Create Group <span class="uiVerticalNav-counter">16</span></a></li>
                        <li><a href="">Vacation <span class="uiVerticalNav-counter">23</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="uiVerticalNav-item">
                        <i class="navMenuIcon-event"></i>
                        Event
                        <span class="uiVerticalNav-counter">42</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
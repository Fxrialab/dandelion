<?php
$information = $this->f3->get('information');
$username = $this->f3->get('username');
$active = $this->f3->get('active');
$f3 = require('navAbout.php');
?>
<div class="rightAboutCol large-70">
    <nav class="ink-navigation">
        <ul class="menu-about-list">
            <h6 class="active">CURRENT CITY AND HOMETOWN</h6>
            <li class="active currentCity">
                <div>
                    <div class="large-10">
                        <img src="<?php echo IMAGES ?>location.png">
                    </div>
                    <div class="large-80">
                        <a href="#" class="location"><?php if (!empty($information->data->current_city)) echo $information->data->current_city ?></a>
                        <p>Current City</p>
                    </div>
                    <?php
                    if ($userID == $profileID)
                    {
                        ?>
                        <div class="large-5 option">
                            <a data-dropdown="#dropdown-current" class="button icon settings"></a>
                            <div id="dropdown-current" class="dropdown dropdown-tip dropdown-anchor-right">
                                <ul class="dropdown-menu option-about">
                                    <li><a href="javascript:void(0)" class="editAboutCity" rel="currentCity">Edit</a></li>
                                    <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </li>
            <li class="homeCity">
                <div>
                    <div class="large-10">
                        <img src="<?php echo IMAGES ?>location.png">
                    </div>
                    <div class="large-80">
                        <a href="#" class="location"><?php if (!empty($information->data->home_city))echo $information->data->home_city ?></a>
                        <p>Home City</p>
                    </div>
                    <?php
                    if ($userID == $profileID)
                    {
                        ?>
                        <div class="large-5 option">
                            <a data-dropdown="#dropdown-home" class="button icon settings"></a>
                            <div id="dropdown-home" class="dropdown dropdown-tip dropdown-anchor-right">
                                <ul class="dropdown-menu option-about">
                                    <li><a href="javascript:void(0)" class="editAboutCity" rel="homeCity">Edit</a></li>
                                    <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </li>
        </ul>
    </nav>
</div>
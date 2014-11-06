<?php
$information = $this->f3->get('information');
$user = $this->f3->get('user');
$active = $this->f3->get('active');
$userID = $this->f3->get('SESSION.userID');
$f3 = require('navAbout.php');

if (!empty($information))
{
    $position = $information->data->position;
    $university = $information->data->university;
    $concentrations = $information->data->concentrations . ' ' . $information->data->work_location;
}
else
{
    $position = '';
    $university = '';
    $concentrations = '';
}
?>
<div class="rightAboutCol large-70">
    <nav class="ink-navigation">
        <ul class="menu-about-list">
            <h6 class="active">WORK</h6>
            <li class="work">
                <div class="large-10">
                    <img src="<?php echo IMAGES ?>location.png">
                </div>
                <div class="large-80">
                    <a href="#" class="location"><?php if (!empty($information->data->work_location)) echo $information->data->work_location ?></a>
                    <p class="position"><span><?php echo $position ?></span> <?php if (!empty($information->data->work_location)) echo $information->data->work_location ?></p>
                </div>
                <?php
                if ($user->recordID == $userID)
                {
                    ?>
                    <div class="large-5 option">
                        <a data-dropdown="#dropdown-work" class="button icon settings"></a>
                        <div id="dropdown-work" class="dropdown dropdown-tip dropdown-anchor-right">
                            <ul class="dropdown-menu option-about">
                                <li><a href="javascript:void(0)" class="editAbout" rel="work">Edit</a></li>
                                <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </li>
            <h6 class="active">COLLEGE</h6>
            <li class="college">
                <div class="large-10">
                    <img src="<?php echo IMAGES ?>people.png">
                </div>
                <div class="large-80">
                    <a href="#" class="location"><?php echo $university ?></a>
                    <p class="position"><?php echo $concentrations ?></p>
                </div>
                <?php
                if ($user->recordID == $userID)
                {
                    ?>
                    <div class="large-5 option">
                        <a data-dropdown="#dropdown-college" class="button icon settings"></a>
                        <div id="dropdown-college" class="dropdown dropdown-tip dropdown-anchor-right">
                            <ul class="dropdown-menu option-about">
                                <li><a href="javascript:void(0)" class="editAbout" rel="college">Edit</a></li>
                                <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </li>
            <h6 class="active">HIGH SCHOOL</h6>
            <li class="school">
                <div class="large-10">
                    <img src="<?php echo IMAGES ?>people.png">
                </div>
                <div class="large-80">
                    <a href="#" class="location"><?php if (!empty($information->data->school)) echo $information->data->school ?></a>
                    <p class="position"><?php if (!empty($information->data->school_location)) echo $information->data->school_location ?></p>
                </div>
                <?php
                if ($user->recordID == $userID)
                {
                    ?>
                    <div class="large-5 option">
                        <a data-dropdown="#dropdown-school" class="button icon settings"></a>
                        <div id="dropdown-school" class="dropdown dropdown-tip dropdown-anchor-right">
                            <ul class="dropdown-menu option-about">
                                <li><a href="javascript:void(0)" class="editAbout" rel="school">Edit</a></li>
                                <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </li>
        </ul>
    </nav>
</div>
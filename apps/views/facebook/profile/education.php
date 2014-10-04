<?php
$f3 = require('navAbout.php');
$information = F3::get('information');
$location = F3::get('location');
if (!empty($location))
    $address = $location->data->city . ', ' . $location->data->country;
else
    $address = '';

if (!empty($information))
{
    $position = $information->data->position;
    $university = $information->data->university;
    $concentrations = $information->data->concentrations . ' ' . $address;
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
                    <a href="#" class="location"><?php echo $address ?></a>
                    <p class="position"><span><?php echo $position ?></span> <?php echo $address ?></p>
                </div>
                <div class="large-5 option">
                    <a data-dropdown="#dropdown-work" class="button icon settings"></a>
                    <div id="dropdown-work" class="dropdown dropdown-tip dropdown-anchor-right">
                        <ul class="dropdown-menu option-about">
                            <li><a href="javascript:void(0)" class="editAbout" rel="work">Edit</a></li>
                            <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                        </ul>
                    </div>
                </div>
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
                <div class="large-5 option">
                    <a data-dropdown="#dropdown-college" class="button icon settings"></a>
                    <div id="dropdown-college" class="dropdown dropdown-tip dropdown-anchor-right">
                        <ul class="dropdown-menu option-about">
                            <li><a href="javascript:void(0)" class="editAbout" rel="college">Edit</a></li>
                            <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                        </ul>
                    </div>
                </div>
            </li>
            <h6 class="active">HIGH SCHOOL</h6>
            <li class="school">
                <div class="large-10">
                    <img src="<?php echo IMAGES ?>people.png">
                </div>
                <div class="large-80">
                    <a href="#" class="location"><?php echo $information->data->school ?></a>
                    <p class="position"><?php echo HelperController::findLocation($information->data->school_location) ?></p>
                </div>
                <div class="large-5 option">
                    <a data-dropdown="#dropdown-school" class="button icon settings"></a>
                    <div id="dropdown-school" class="dropdown dropdown-tip dropdown-anchor-right">
                        <ul class="dropdown-menu option-about">
                            <li><a href="javascript:void(0)" class="editAbout" rel="school">Edit</a></li>
                            <li><a href="javascript:void(0)" class="workDelete">Delete</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
</div>
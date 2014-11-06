<?php
$information = $this->f3->get('information');
$user = $this->f3->get('user');
$active = $this->f3->get('active');
$userID = $this->f3->get('SESSION.userID');
$f3 = require('navAbout.php');
?>
<div class="rightAboutCol large-70">
    <nav class="ink-navigation">
        <ul class="menu-about-list">
            <h6 class="active">CONTACT INFORMATION</h6>
            <li class="active contactPhone">
                <div>
                    <div class="large-30">
                        Mobile Phones
                    </div>
                    <div class="large-60 phone">
                        <?php  if (!empty($information->data->phone_mobile)) echo $information->data->phone_mobile ?>
                    </div>
                    <?php
                    if ($userID == $user->recordID)
                    {
                        ?>
                        <div class="large-5 option">
                            <a href="javascript:void(0)" class="editAboutCity" rel="contactPhone">Edit</a>
                        </div>
                    <?php } ?>
                </div>
            </li>
            <li>
                <div class="large-30">
                    Email
                </div>
                <div class="large-70">
                    <?php echo $user->data->email ?>
                </div>
            </li>
            <h6 class="active">BASIC INFORMATION</h6>
            <li class="active birthday">
                <div>
                    <div class="large-30">
                        Birthday
                    </div>
                    <div class="large-60">
                        <?php if (!empty($information->data->birthday)) echo $information->data->birthday ?>
                    </div> 
                    <?php
                    if ($userID == $user->recordID)
                    {
                        ?>
                        <div class="large-5 option">
                            <a href="javascript:void(0)" class="editAboutCity" rel="birthday">Edit</a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </li>
            <li class="gender">
                <div class="large-30">
                    Gender
                </div>
                <div class="large-60">
                    <?php if (!empty($information->data->gender)) echo $information->data->gender ?>
                </div>
                <?php
                if ($userID == $user->recordID)
                {
                    ?>
                    <div class="large-5 option">
                        <a href="javascript:void(0)" class="editAboutCity" rel="gender">Edit</a>
                    </div>
                <?php } ?>
            </li>
        </ul>
    </nav>
</div>
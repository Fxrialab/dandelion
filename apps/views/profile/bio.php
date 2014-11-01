<?php
$information = $this->f3->get('information');
$username = $this->f3->get('username');
$active = $this->f3->get('active');
$f3 = require('navAbout.php');
?>
<div class="rightAboutCol large-70">
    <nav class="ink-navigation">
        <ul class="menu-about-list">
            <h6 class="active">ABOUT YOU</h6>
            <li class="editabout">
                <?php
                if (!empty($information->data->about))
                {
                    ?>
                    <div class="large-90 divabout">
                        <?php echo $information->data->about ?>
                    </div>
                    <?php
                    if ($userID == $profileID)
                    {
                        ?>
                        <div class="large-5 option">
                            <a href="javascript:void(0)" class="editAboutCity" rel="editabout">Edit</a>
                        </div>

                        <?php
                    }
                }
                else
                {
                    if ($userID == $profileID)
                    {
                        ?>
                        <a href="javascript:void(0)" rel="editabout">Write some details about yourself</a>
                        <?php
                    }
                }
                ?>
            </li>
            <h6 class="active">OTHER NAME</h6>
            <li class="editname">
                <div class="large-90 divname">
                    <?php echo $fullname ?>
                </div>
                <?php
                if ($userID == $profileID)
                {
                    ?>
                    <div class="large-5 option">
                        <a href="javascript:void(0)" class="editAboutCity" rel="editname">Edit</a>
                    </div>
                <?php } ?>
            </li>
            <h6 class="active">FAVORITE QUOTES</h6>
            <li>
                <a href="javascript:void(0)">Add your favorite quotations</a>
            </li>
        </ul>
    </nav>
</div>
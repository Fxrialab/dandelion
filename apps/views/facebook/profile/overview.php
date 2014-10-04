<?php
$location = F3::get('location');
$f3 = require('navAbout.php');
?>
<div class="rightAboutCol large-70">
    <nav class="ink-navigation">
        <ul class="menu-about-list">
            <li class="active">
                <div class="large-10">
                    <img src="<?php echo IMAGES ?>location.png">
                </div>
                <div class="large-90">
                    Web Developer tai <a href="#"><?php echo $location->data->city . ', ' . $location->data->country ?></a>
                </div>

            </li>
            <li class="active">
                <div class="large-10">
                    <img src="<?php echo IMAGES ?>people.png">
                </div>
                <div class="large-90">
                    Hoc cong nghe thong tin tai <a href="#">Duy Tan</a>
                </div>
            </li>
            <li>
                <div class="large-10">
                    <img src="<?php echo IMAGES ?>location.png">
                </div>
                <div class="large-90">
                    Song tai <a href="#">Da Nang, Viet Nam</a>
                </div>
            </li>
        </ul>
    </nav>
</div>
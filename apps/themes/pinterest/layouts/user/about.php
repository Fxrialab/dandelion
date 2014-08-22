<?php
$user = F3::get('user');
?>
<div class="column-group">
    <div class="large-60 medium-100 small-100 push-center">
        <div class="column-group">
            <div class="large-30">
                <div class="about-left">
                    <nav class="ink-navigation">
                        <ul class="menu vertical">
                            <li><a href="#">Account Basic</a></li>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Email Notifications</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="large-70">
                <div class="about-right">
                    <form class="ink-form" style="margin: 0; padding: 10px 0;">
                        <div class="column-group">
                            <h4 style="margin-left: 10px">Account Basic</h4>
                        </div>
                        <div class="control-group column-group ">
                            <label for="name" class="large-30">Email Address</label>
                            <div class="control large-70">
                                <input type="text" id="email" value="<?php echo $user->data->email ?>">
                            </div>
                        </div>
                        <div class="control-group column-group ">
                            <label for="name" class="large-30">Password</label>
                            <div class="control large-70">
                                <a href="javascript:void(0)">Change Password</a>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="name" class="large-30">Gender</label>
                            <div class="control large-70">
                                <nav class="ink-navigation">
                                    <ul class=" menu horizontal">
                                        <li><input type="radio" id="rb1" name="rb" value="Ace of Spades"><label for="rb1">Made</label></li>
                                        <li><input type="radio" id="rb2" name="rb" value="Queen of Diamonds"><label for="rb2">Femade</label></li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="about-right">
                    <form class="ink-form" style="margin: 0; padding: 10px 0;">
                        <div class="column-group">
                            <h4 style="margin-left: 10px">Profile</h4>
                        </div>
                        <div class="control-group column-group ">
                            <label for="name" class="large-30">Name</label>
                            <div class="control large-35">
                                <input type="text" style="margin-right: 5px" name="lastName"  value="<?php echo $user->data->firstName ?>">
                            </div>
                            <div class="control large-35">
                                <input type="text" style="margin-left: 5px" name="firstName" value="<?php echo $user->data->lastName ?>">
                            </div>
                        </div>
                        <div class="control-group column-group ">
                            <label for="name" class="large-30">Picture</label>
                            <div class="control large-70">
                                <a class="ink-button link-button" href="javascript:void(0)">Change Picture</a>
                            </div>
                        </div>
                        <div class="control-group column-group ">
                            <label for="name" class="large-30">Username</label>
                            <div class="control large-70">
                                <input type="text" name="username" value="<?php echo $user->data->username ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
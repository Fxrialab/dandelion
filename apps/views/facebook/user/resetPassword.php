<div class="column-group">
    <div class="large-60 medium-100 small-100 push-center">
        <div class="column-group">
            <div class="uiForgotPWBox">
                <div class="boxTitle">
                    Reset Your Password
                </div>
                <div class="boxContent forgotPwContent">
                    <div class="forgotContainer">
                        <form action="/resetPassword" method="post" class="ink-form">
                            <div class="title content-center">
                                <span>This form help you authentication your account. Then send a code to mail for confirmation</span>
                            </div>
                            <div class="column-group large-100">
                                <div class="large-70 leftColBox">
                                    <fieldset>
                                        <div class="control-group">
                                            <p class="label">How would you like to reset your password?</p>
                                            <ul class="control unstyled">
                                                <li>
                                                    <input type="radio" id="rb1" checked="1">
                                                    <label class="fixMargin" for="rb1">Please send a password reset link to my email <?php echo $user->data->email;?></label>
                                                </li>
                                            </ul>
                                            <input name="email" type="hidden" value="<?php echo $user->data->email;?>" />
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="large-30 rightColBox">
                                    <div class="imgSearch">
                                        <?php
                                        if ($user->data->profilePic == 'none')
                                        {
                                            $gender = HelperController::findGender($user->recordID);
                                            if ($gender == 'male')
                                                $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                                            else
                                                $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
                                        }else {
                                            $photo = HelperController::findPhoto($user->data->profilePic);
                                            $avatar = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
                                        }
                                        ?>
                                        <img src="<?php echo $avatar;?>">
                                    </div>
                                    <div class="infoSearch">
                                        <p class="timeLineLink fixColor-0069d6"><?php echo ucfirst($user->data->firstName) . ' ' . ucfirst($user->data->lastName);?></p>
                                        <span><a href="/forgotPassword">Not Me?</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="footerBox column-group">
                                <input type="submit" class="ink-button push-right" value="Continue">
                                <a class="ink-button blue push-right" href="/">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

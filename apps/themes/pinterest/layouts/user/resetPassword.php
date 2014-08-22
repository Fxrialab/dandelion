<div class="column-group">
    <div class="large-80 medium-100 small-100 push-center lineStroke overflowStyle">
        <div class="column-group">
            <div class="large-65 push-center fixMarginBottom-5">
                <a id="uiLogInLink" class="uiTabNav linkColor-9aa9c8 fontSize-18" name="uiLogInBox">Log In</a>
                <div class="quickLogInBox" id="uiLogInBox">
                    <form class="ink-form fixMarginTop-10" method="post" action="/login" id="fmLogIn">
                        <div class="column-group fixMarginBottom-5">
                            <div class="large-40">
                                <input type="text" class="fixWidth220" placeholder="Your Email" name="emailLogIn" id="emailLogIn">
                            </div>
                            <div class="large-40">
                                <input type="password" class="fixWidth220" placeholder="Your Password" name="pwLogIn" id="pwLogIn">
                            </div>
                            <div class="large-20">
                                <input type="submit" class="uiMediumButton orange" id="smLogIn" name="smLogIn" value="Log In">
                            </div>
                        </div>
                        <div class="column-group">
                            <div class="large-40">
                                <input id="cbRememberMe" class="cbRememberMe" type="checkbox" name="persistent" value="1">
                                <label for="cbRememberMe" class="linkColor-9aa9c8">Remember Me</label>
                            </div>
                            <div class="large-40">
                                <a class="linkColor-9aa9c8" href="/forgotPassword">Forgot Password</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                        <img src="<?php echo $user->data->profilePic;?>">
                                    </div>
                                    <div class="infoSearch">
                                        <p class="timeLineLink fixColor-0069d6"><?php echo $profileName;?></p>
                                        <span><a href="/forgotPassword">Not Me?</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="footerBox column-group">
                                <input type="submit" class="uiMediumButton white large-20 push-right" value="Continue">
                                <a class="uiMediumButton white large-20 push-right" href="/">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

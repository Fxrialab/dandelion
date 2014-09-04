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
                    Confirmation Code
                </div>
                <div class="boxContent forgotPwContent">
                    <div class="forgotContainer">
                        <form action="/confirmPassword" method="post" class="ink-form" id="fmConfirmCode">
                            <div class="title content-center">
                                <span>We have sent you an email containing the confirmation code of six digits. Enter the code below to reset your password.</span>
                            </div>
                            <div class="column-group large-100">
                                <div class="large-30 leftColBox">
                                    <div class="content-right">
                                        <input type="text" size="6" name="confirmCode" id="confirm">
                                    </div>
                                </div>
                                <div class="large-70 rightColBox">
                                    <p class="label">We have sent you the code to: <strong><?php echo $email;?></strong></p>
                                </div>
                            </div>
                            <div class="footerBox column-group">
                                <input id="confirmCode" type="submit" class="uiMediumButton white large-20 push-right" value="Confirm">
                                <a class="uiMediumButton white large-20 push-right" href="/">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

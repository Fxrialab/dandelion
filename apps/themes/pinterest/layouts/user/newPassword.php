<script type="text/javascript">

</script>
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
                    Create New Password
                </div>
                <div class="boxContent forgotPwContent">
                    <div class="forgotContainer">
                        <div class="title content-center">
                            <span>A strong password is a combination of letters and punctuation marks. It must be at least 6 characters long.</span>
                        </div>
                        <form class="ink-form top-space" method="post" action="/newPassword" id="fmNewPassWord">
                            <fieldset class="column-group horizontal-gutters">
                                <div class="control-group large-100 medium-100 small-100">
                                    <div class="large-40 leftCol content-right">
                                        <div class="large-100 fixmarginbottom-5">New Password</div>
                                        <div class="large-100">Confirm Password</div>
                                    </div>
                                    <div class="large-60 rightCol">
                                        <div class="large-100 fixMarginBottom-5">
                                            <input type="password" name="pWord" id="pWord">
                                        </div>
                                        <div class="large-100">
                                            <input type="password" name="rePWord" id="rePWord">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="footerBox column-group">
                            <a id="smNewPWord" class="uiMediumButton white large-20 push-right" href="">Finish</a>
                            <a class="uiMediumButton white large-20 push-right" href="/">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                    Authentication Account
                </div>
                <div class="boxContent forgotPwContent">
                    <div class="forgotContainer">
                        <div class="title content-center">
                            <span>You are logged in another devices or your account was attacked. Please authentication account!</span>
                        </div>
                        <form class="ink-form top-space" method="post" action="/authentication" id="fmForgotPassword">
                            <fieldset class="column-group horizontal-gutters">
                                <div class="control-group large-100 medium-100 small-100">
                                    <div class="column-group horizontal-gutters">
                                        <label for="email" class="large-20 medium-20 small-10 content-right">Email</label>
                                        <div class="control large-60 medium-80 small-90 prepend-symbol">
                                        <span>
                                            <input type="text" id="ipEmail" name="email">
                                            <i class="icon-envelope-alt"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <div class="footerBox column-group">
                            <a id="searchEmail" class="uiMediumButton white large-20 push-right" href="">Send Request</a>
                            <a class="uiMediumButton white large-20 push-right" href="/">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

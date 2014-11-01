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
                            <div class="title content-center fixMarginBottom-15">
                                <span>We have sent you an email containing the confirmation code of six digits. Enter the code below to reset your password.</span>
                            </div>
                            <div class="column-group large-100">
                                <div class="large-30 leftColBox">
                                    <div class="content-right">
                                        <input type="text" size="6" name="confirmCode" id="confirm">
                                    </div>
                                </div>
                                <div class="large-70 rightColBox fixPaddingLeft-10">
                                    <p class="label">We have sent you the code to: <strong><?php echo $email;?></strong></p>
                                </div>
                            </div>
                            <div class="footerBox column-group">
                                <input id="confirmCode" type="submit" class="ink-button push-right" value="Confirm">
                                <a class="ink-button blue push-right" href="/">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

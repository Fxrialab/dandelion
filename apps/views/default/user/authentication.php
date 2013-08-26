<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/1/13 - 4:10 PM
 * Project: joinShare Network - Version: 1.0
 */
?>
<div class="" id="reg_error"></div>
<div class="loginBlock" id="forgot">
    <div class="wrapperForgot">
        <h1 class="findYour">Check email?</h1>
        <div class="dr"><span>You are logged in another devices or ...Please authentication account!</span></div>
        <form id="email_form_box" action="/authentication" method="post">
            <div class="loginForm">
                <p class="thisform">Please input email</p>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><img src="<?php echo F3::get("STATIC");?>images/email.gif" /></span>
                        <input style="width:250px;" name="email" id="email" onkeyup="HideMessage();">
                    </div>
                    <div class="message">
                        <span id="email_error"></span>
                    </div>
                </div>
                <div class="dr drbottom"><span></span></div>
                <div class="controls">
                    <div class="row-fluid">
                        <div class="btn_send">
                            <input id="sendRequest" class="sendrequest" type="submit" value="Send request" />
                            <a class="cancelAction" title="Close" href="/">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
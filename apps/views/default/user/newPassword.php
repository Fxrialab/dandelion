<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/2/13 - 11:39 PM
 * Project: joinShare Network - Version: 1.0
 */
//@TODO: Assign->Huong: check validate two password input
?>
<div class="loginBlock" id="forgot">
    <div class="wrapperForgot">
        <h1 class="findYour">Create new password</h1>
        <div class="dr"><span></span></div>
        <form id="new_form_box" action="/newPassword" method="post">
            <div class="loginForm">
                <p class="thisform">A strong password is a combination of letters and punctuation marks. It must be at least 6 characters long.</p>
                <div class="control-group" style="margin-left: -30px;">
                    <div class="input-prepend">
                        <div class="wrapper_input">
                            <label class="title_email">New Password:</label>
                            <input style="width:175px;" type="password" name="password" id="password" onkeyup="hideMsg();"><span style="color: red;">(*)</span>
                        </div>
                        <div class="wrapper_input">
                            <label class="title_email">Confirm Password:</label>
                            <input style="width:175px;" type="password" name="re_password" id="r_password" onkeyup="hideMsg();"><span style="color: red;">(*)</span>
                        </div>
                        <div class="wrapper_input">
                            <div class="wrapper_error">
                                <span id="email_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dr drbottom"><span></span></div>
                <div class="controls">
                    <div class="row-fluid">
                        <div class="btn_send">
                            <input id="new_password" class="sendrequest" type="submit" value="Finish" />
                            <a href="#" class="cancelAction" title="Back">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#new_password').click(function(e) {
            e.preventDefault();
            var validate = validatePassInput();
            if(validate != ''){
                $('#email_error').html(msgValidate);
                $('#email_error').show();
                $('#email_error').css("height","auto");
            }
            else{
                $('#new_form_box').submit();
            }
        });
    });

    function validatePassInput(){
        msgValidate   = '';
        var newPass   = $('#password').val();
        var reNewPass = $('#r_password').val();
        if(newPass == '')
        {
            msgValidate = "Must not empty.";
        }
        if(newPass.length < 6)
        {
            msgValidate =   "Length 6 in case";
        }
        if(reNewPass != newPass)
        {
            msgValidate =   'Two password does not match';
            reNewPass.focus();
        }
        return msgValidate;
    }

    function hideMsg(){
        $('#email_error').hide();
    }
</script>
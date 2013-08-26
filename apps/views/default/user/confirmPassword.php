<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/2/13 - 11:15 PM
 * Project: joinShare Network - Version: 1.0
 */
$email=F3::get('email');
?>
<div class="loginBlock" id="forgot">
    <div class="wrapperForgot">
        <h1 class="findYour">Check your email</h1>
        <div class="dr"><span></span></div>
        <form id="confirm_form_box" action="/confirmPassword" method="post">
            <div class="loginForm">
                <p class="thisform">Check email - we have sent you an email containing the confirmation code of six digits. Enter the code below to reset your password.</p>
                <div class="control-group" style="margin-left: -30px;">
                    <div class="input-prepend">
                        <div class="wrapper_input">
                            <input style="background-color: rgb(240, 231, 231); width:104px; font-size: 30px;color: #777;" name="confirmCode" id="confirm" onkeyup="HideMessage();">
                            <div class="titleConfirm">
                                <lable class="title_confirm">We have sent you the code to:</lable>
                                <lable class="title_confirm confirm_child"><?php echo $email; ?></lable>
                            </div>
                        </div>
                        <div class="wrapper_input">
                            <div class="wrapper_error" style="margin-top: -9px;margin-left: 0px;">
                                <span id="email_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dr drbottom"><span></span></div>
                <div class="controls">
                    <div class="row-fluid">
                        <div class="btn_send">
                            <input id="confirm_password" class="sendrequest" type="submit" value="Cofirm" />
                            <a href="/" class="cancelAction" title="Back">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#confirm_password').click(function(e) {
            e.preventDefault();
            var err_message_singup = CheckConfirm();
            if(err_message_singup != ""){
                $('#email_error').html(message_error);
                $('#email_error').show();
                $('#email_error').css("height","auto");
            }
            else{
                $('#confirm_form_box').submit();
            }
        });
    });

    function CheckConfirm(){
        message_error   =   "";
        var confirm     = $('#confirm').val();
        if(confirm=="")
        {
            message_error   = "Must not empty.";
            return message_error;
        }
        if(confirm.length   <   6   ||    confirm.length  >   6)
        {
            message_error   =   "length 6 in case";
            return message_error;
        }
        return message_error;
    }

    function HideMessage(){
        $('#email_error').hide();
    }
</script>
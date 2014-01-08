/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 7/8/13
 * Time: 9:09 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){
    $('#contact_password').click(function(e) {
        e.preventDefault();
        var err_message_singup = Check();
        if(err_message_singup != ""){
            $('#email_error').html(message_error);
            $('#email_error').show();
            $('#email_error').css("height","auto");
        }
        else{
            $('#contact_form_box').submit();
        }
    });
});

function Check(){
    message_error = "";
    var r_email=document.getElementById('r_email');
    var email=document.getElementById('Email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if( $('#email').val()=="" || $('#r_email').val()==""){
        email.focus();
        message_error = "You must enter the email.";
        return message_error;
    }
    if(!filter.test(email.value)){
        email.focus();
        message_error = "Incorrectly formatted email";
        return message_error;
    }
    if( $('#r_email').val() != $('#Email').val()){
        r_email.focus();
        message_error = "Confirmation email not true.";
    }
    return message_error;
}

function HideMessage(){
    $('#email_error').hide();
}
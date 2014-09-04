$(document).ready(function(){
    $('#sendRequest').click(function(e) {
        e.preventDefault();
        var err_message_singup = CheckEmail();
        if(err_message_singup != ""){
            $('#email_error').html(message_error);
            $('#email_error').show();
            $('#email_error').css("height","auto");
        }
        else{
            $('#email_form_box').submit();
        }
    });
});

function CheckEmail(){
    message_error = "";
    var email=document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if( $('#email').val()==""){
        message_error = "You must enter the email.";
        return message_error;
    }
    if(!filter.test(email.value)){
        email.focus();
        message_error = "Incorrectly formatted email";
        return message_error;
    }
    return message_error;
}

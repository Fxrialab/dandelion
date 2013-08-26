$(document).ready(function(){
    $('#submitForm').click(function(e) {
        e.preventDefault();

        var err_message_singup = CheckSignUp();
        if(err_message_singup != "")
        {
            $('#reg_error').html(message_error);
            $('#reg_error').show();
            $('#reg_error').css("height","auto");
        }
        else{
            $('#reg_form_box').submit();
        }
    });
    $('#login_submit').click(function (e) {
        e.preventDefault();

        var err_message_signin = CheckSignIn();
        if(err_message_signin != "")
        {
            $('#error_signin').html(errorMsg_signin);
            $('#error_signin').show();
            $('#error_signin').css('height','auto');
            $('#errorMsg').show();
        }else {
            $('#login_form').submit();
        }
    });
});

function CheckSignUp()
{
    message_error = "";
    var email=document.getElementById('email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var chkBox = document.getElementById('regCheckbox');
    if (!chkBox.checked)
    {
        message_error   =   "Please agree to the Terms and Privacy Policy";
    }
    if(!filter.test(email.value))
    {
        message_error = "Incorrectly formatted email";
    }
    if( $('#firstname').val()=="" || $('#lastname').val()==""
        || $('#email').val()=="" || $('#password').val()==""
        || $('#postalCode').val()=="" || $('#sex').val()==""
        || $('#birthday_month').val()=="" || $('#birthday_day').val()==""
        || $('#birthday_year').val()==""  )
    {
        message_error = "You have to fill in all fields.";
    }
    return message_error;
}

function CheckSignIn()
{
    errorMsg_signin = "";
    var filter      =   /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var email       =   document.getElementById('login_email');
    var password    =   document.getElementById('login_password');
    if(!filter.test(email.value))
    {
        errorMsg_signin = "Incorrectly formatted email";
    }
    if(email.value=="" || password.value=="")
    {
        errorMsg_signin =   "You must enter the full email and password";
    }

    return errorMsg_signin;
}
function HideMessage()
{
    $('#error_signin').hide();
    $('#errorMsg').hide();
}

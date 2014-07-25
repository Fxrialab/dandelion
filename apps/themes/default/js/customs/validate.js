$(document).ready(function(){
    $('#smLogIn').click(function (e) {
        e.preventDefault();
        var existedMsgLogIn = $('#msgLogIn').length;
        if (existedMsgLogIn > 0)
            $('#msgLogIn').detach();

        var msgSignIn = CheckSignIn();
        if(msgSignIn != "")
        {
            $('#uiLogInBox').append("<div class='ink-alert basic success' id='msgLogIn'>" +
                "<button class='ink-dismiss'>&times;</button>" +
                "<p>"+msgSignIn+"</p></div> ");
        }else {
            $('#fmLogIn').submit();
        }
    });
    $('#smSignUp').click(function(e) {
        e.preventDefault();
        var existedMsgSignUp = $('#msgSignUp').length;
        if (existedMsgSignUp > 0)
            $('#msgSignUp').detach();

        var msgSignUp = CheckSignUp();
        if(msgSignUp != "")
        {
            $('#uiSignUpBox').append("<div class='ink-alert basic success' id='msgSignUp'>" +
                "<button class='ink-dismiss'>&times;</button>" +
                "<p>"+msgSignUp+"</p></div> ");
        }else {
            $('#fmSignUp').submit();
        }
    });
    $('#searchEmail').click(function(e) {
        e.preventDefault();
        var existedMsgCheckMail = $('#msgOther').length;
        if (existedMsgCheckMail > 0)
            $('#msgOther').detach();

        var msg = CheckEmail();
        if(msg != ""){
            $('.title').append("<div class='ink-alert basic success' id='msgOther'>" +
                "<button class='ink-dismiss'>&times;</button>" +
                "<p>"+msg+"</p></div> ");
        }
        else{
            $('#fmForgotPassword').submit();
        }
    });
    $('#confirmCode').click(function(e) {
        e.preventDefault();
        var existedMsgCheckMail = $('#msgOther').length;
        if (existedMsgCheckMail > 0)
            $('#msgOther').detach();

        var msg = CheckConfirmCode();
        if(msg != ""){
            $('.title').append("<div class='ink-alert basic success' id='msgOther'>" +
                "<button class='ink-dismiss'>&times;</button>" +
                "<p>"+msg+"</p></div> ");
        }
        else{
            $('#fmConfirmCode').submit();
        }
    });
    $('#smNewPWord').click(function(e) {
        e.preventDefault();
        var existedMsgCheckMail = $('#msgOther').length;
        if (existedMsgCheckMail > 0)
            $('#msgOther').detach();

        var msgValidate = CheckValidateNewPassword();
        if(msgValidate != ""){
            $('.title').append("<div class='ink-alert basic success' id='msgOther'>" +
                "<button class='ink-dismiss'>&times;</button>" +
                "<p>"+msgValidate+"</p></div> ");
        }
        else{
            $('#fmNewPassWord').submit();
        }
    });
});

function CheckSignUp()
{
    msgErrorSignUp  = "";
    var email       = document.getElementById('emailSignUp');
    var filter      = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var chkBox      = document.getElementById('cbAgreeTermsPrivacyPolicy');
    if (!chkBox.checked) msgErrorSignUp = "Please agree to the Terms and Privacy Policy";
    if (!filter.test(email.value) && email.value !="") msgErrorSignUp = "Incorrectly formatted email";
    if ($('#firstNameSignUp').val()=="" || $('#lastNameSignUp').val()==""
        || $('#emailSignUp').val()=="" || $('#pwSignUp').val()==""
        || $('#genderSignUp').val()=="" || $('#birthdayMonthSignUp').val()==""
        || $('#birthdayDaySignUp').val()=="" || $('#birthdayYearSignUp').val()=="")
    {
        msgErrorSignUp = "You have to fill in all fields.";
    }
    return msgErrorSignUp;
}

function CheckSignIn()
{
    msgErrorSignIn  = "";
    var filter      = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var email       = document.getElementById('emailLogIn');
    var password    = document.getElementById('pwLogIn');
    if (!filter.test(email.value) && email.value !="") msgErrorSignIn = "Incorrectly formatted email";
    if (email.value=="" || password.value=="") msgErrorSignIn =   "You must enter the full email and password";
    return msgErrorSignIn;
}

function CheckEmail(){
    msg         = '';
    var email   = document.getElementById('ipEmail');
    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ($('#ipEmail').val()== '') msg = "You must fill to email.";
    if ($('#ipEmail').val() != '' && !filter.test(email.value)) msg = "Incorrectly formatted email";
    return msg;
}

function CheckConfirmCode() {
    msg   =   "";
    var confirm = $('#confirm').val();
    if (confirm =="") msg   = "Code should not empty";
    if (confirm.length < 6 || confirm.length > 6) msg   = "Length 6 in case";
    return msg;
}

function CheckValidateNewPassword() {
    msgValidate   =   "";
    var newPass   = $('#pWord').val();
    var reNewPass = $('#rePWord').val();
    if(newPass == '') msgValidate = "Password should not empty";
    if(reNewPass != newPass) msgValidate = 'Two password does not match';
    return msgValidate;
}


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
                "<p>"+msgErrorSignIn+"</p></div> ");
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
                "<p>"+msgErrorSignUp+"</p></div> ");
        }else {
            $('#fmSignUp').submit();
        }
    });

});

function CheckSignUp()
{
    msgErrorSignUp  = "";
    var email       = document.getElementById('emailSignUp');
    var filter      = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var chkBox      = document.getElementById('cbAgreeTermsPrivacyPolicy');
    if (!chkBox.checked)
    {
        msgErrorSignUp = "Please agree to the Terms and Privacy Policy";
    }
    if(!filter.test(email.value))
    {
        msgErrorSignUp = "Incorrectly formatted email";
    }
    if( $('#firstNameSignUp').val()=="" || $('#lastNameSignUp').val()==""
        || $('#emailSignUp').val()=="" || $('#pwSignUp').val()==""
        || $('#genderSignUp').val()==""
        || $('#birthdayMonthSignUp').val()=="" || $('#birthdayDaySignUp').val()==""
        || $('#birthdayYearSignUp').val()==""  )
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
    if(!filter.test(email.value))
    {
        msgErrorSignIn = "Incorrectly formatted email";
    }
    if(email.value=="" || password.value=="")
    {
        msgErrorSignIn =   "You must enter the full email and password";
    }

    return msgErrorSignIn;
}


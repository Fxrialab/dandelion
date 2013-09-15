<?php
class EmailHelper {
	public function __construct() {}
	
	public function sendEmail($from, $to, $subject, $body) {
		$header = 'From: '.$from."\r\n" .
				  'Reply-To: '.$from."\r\n" .
				  'Return-Path: '.$from."\r\n" .
				  'X-mailer: UserWired-Mailer'."\r\n";
		mail($to, $subject, $body, $header);        		
	}

    public function sendConfirmationEmail($email,$confirmCode) {
        $linkConfirm    = BASE_URL."confirm?email=".$email."&confirmationCode=".$confirmCode;
        $from           = "admin@userwired.com";
        $to             = $email;
        $subject        = "UserWired Network - Confirmation Email";
        $message        = "Please, you click to link confirmation code: ".$linkConfirm;
        $this->sendEmail($from, $to, $subject, $message);
    }

    public function sendCodeConfirmEmail($email, $code)
    {
        $from           = "admin@userwired.com";
        $to             = $email;
        $subject        = "UserWired Network send code for authentication email ";
        $message        = "Your code is: " . $code;
        $this->sendEmail($from, $to, $subject, $message);
    }

    public function sendCodeConfirmPass($email, $code)
    {
        $from           = "admin@userwired.com";
        $to             = $email;
        $subject        = "UserWired Network send code for reset password ";
        $message        = "Your code is: " . $code;
        $this->sendEmail($from, $to, $subject, $message);
    }
	
	// @todo: refine email and using template for it
	public function prepareEmail($email, $templateFile) {
		return '';
	}
}

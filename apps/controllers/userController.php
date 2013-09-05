<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 2:46 PM
 * Project: UserWired Network - Version: beta
 */
class UserController extends AppController
{
    protected $uses     = array("User", "Notify", "Sessions", "Post");
    protected $helpers  = array("Encryption", "Validate", "Email", "String", "Time");

    public function __construct()
    {
        parent::__construct();
    }

    public function signUp()
    {
        $this->layout = 'index';
        //get and prepare data for sign up
        $data = F3::get('POST');
        if (isset($data['email']))
        {
            //check email field has existed in DB
            $isUsedEmail = $this->User->findOne("email = ?", array($data["email"]));
            //data is alright, create new user then send confirmation code to email
            if ($this->ValidateHelper->validation($data, $isUsedEmail, false) == '')
            {
                if(isset($data['regCheckbox']))
                {
                    // prepare birthday data
                    $data['birthday']   = date("F-d-Y", mktime(0,0,0,$data['birthdayMonth'],$data['birthdayDay'],$data['birthdayYear']));
                    unset($data['birthdayDay']);
                    unset($data['birthdayMonth']);
                    unset($data['birthdayYear']);
                    // set username for friends can view your profile using the link
                    $data['username'] = substr($data["email"], 0, strpos($data["email"], '@'));
                    // set default avatar
                    $data['profilePic'] = ($data['sex'] == 1) ? IMAGES."avatarWomenDefault.jpg" : IMAGES."avatarMenDefault.jpg";
                    // encrypt password
                    $data['password']   = $this->EncryptionHelper->HashPassword($data["password"]);
                    // set signUp status
                    $data['status']     = 'pending';
                    $data['role']       = 'user';
                    // and create time
                    $data['created']    = time();
                    //generate confirmation code
                    $confirmationCode   = $this->StringHelper->generateRandomString(32);
                    $data['confirmationCode']   = $confirmationCode;
                    // valid in 24 hours
                    $confirmationCodeValidUntil = $this->TimeHelper->getTommorrow();
                    $data['confirmationCodeValidUntil'] = $confirmationCodeValidUntil;

                    // exclude form submit button and checkbox from data and create a new user
                    //$userID = $this->User->createRecord($data, 'submitForm,regCheckbox');
                    $this->User->create($data, 'submitForm,regCheckbox');
                    $this->EmailHelper->sendConfirmationEmail($data['email'],$confirmationCode);

                    F3::set('MsgSignUp','You are registered success. Please check mail and confirm !');
                    $this->render('user/signUp.php', 'default');
                }else {
                    F3::set('MsgSignUp','Please agree to the Terms and Privacy Policy');
                    $this->render('user/signUp.php', 'default');
                }
            }else {
                F3::set('MsgSignUp', $this->ValidateHelper->validation($data,$isUsedEmail, false));
                $this->render('user/signUp.php', 'default');
            }
        }
    }

    public function confirm()
    {
        //Set layout default
        $this->layout       = 'index';
        $request            = F3::get('GET');
        $email              = $request['email'];
        $confirmationCode   = $request['confirmationCode'];
        if ($email && $confirmationCode)
        {
            $user           = $this->User->findOne('email = ?', array($email));
            if ($user->data->confirmationCode != '')
            {
                if (($user->data->confirmationCode == $confirmationCode) &&
                    (time() <= $user->data->confirmationCodeValidUntil))
                {
                    // change status
                    $user->data->status = 'confirmed';
                    // reset confirmation info
                    $user->data->confirmationCode = '';
                    $user->data->confirmationCodeValidUntil = NULL;
                    $this->User->update($user->recordID, $user);
                    /* Create notify for user */
                    $notify = array(
                        'userID'        => $user->recordID,
                        'notify'        => 0,
                        'requestFriend' => 0,
                        'message'       => 0
                    );
                    $notify = $this->Notify->create($notify);
                    echo $notify."<br />";
                    //$this->Edge->createEdge('#'.$user->recordID, '#'.$notify);
                    F3::set('MsgConfirm','Thank you confirm email. Now, you can login !') ;
                }else {
                    F3::set('MsgConfirm','The confirmation code or email are incorrect. Please, try check mail again !');
                }
            }
            $this->render('user/confirmEmail.php','default');
        }
    }

    public function login()
    {
        $this->layout   = 'index';
        $request        = F3::get('POST');
        if (!empty($request))
        {
            $email      = $request['email'];
            $password   = $request['password'];
            $existUser  = $this->User->findOne("email = ? AND role = ?", array($email,'user'));

            if (!empty($existUser))
            {
                if ($this->EncryptionHelper->CheckPassword($password, $existUser->data->password)) {
                    //Check status of user. If status='pending' must enter confirm code
                    if($existUser->data->status == 'pending')
                    {
                        F3::set('MsgSignIn','We have sent an confirmation email to you. Please check the email and confirm your email with us !');
                        $this->render('user/signUp.php', 'default');
                    }else {
                        if (isset($request['persistent'])==true)
                        {
                            setcookie('email', $email, time()+ 7 * 24 * 60 *60);
                            setcookie('password', $password, time()+ 7 * 24 * 60 *60);
                        }else {
                            setcookie('email', $email, time()-3600);
                            setcookie('password', $password , time()-3600);
                        }
                        F3::clear('SESSION');
                        F3::set('SESSION.loggedUser', $existUser);
                        // start initial sessions.
                        $sessionID          = rand(1000,10000000);
                        $macAddress         = $this->getMacAddress();
                        $ipAddress          = $this->getIPAddress();
                        $existSessionUser   = $this->Sessions->findOne("email = ? AND status = ?", array($email, 'Active'));

                        if($existSessionUser)
                        {
                            $getMACAddress  = $existSessionUser->data->macAddress;
                            if ($macAddress == $getMACAddress)
                            {
                                //update status for current session
                                $currentSession = array(
                                    'timeEnd'   	=> time(),
                                    'status'    	=> 'Disable',
                                );
                                $this->Sessions->updateByCondition($currentSession,"email = ? AND status = ? ",array($email,'Active'));
                                //then create new session
                                $newSession = array(
                                    'email'             => $email,
                                    'sessionID'         => $sessionID,
                                    'created'           => time(),
                                    'timeStart'         => time(),
                                    'timeEnd'           => '',
                                    'macAddress'        => $macAddress,
                                    'externalIpAddress' => $ipAddress,
                                    'status'            => 'Active',
                                );
                                $this->Sessions->create($newSession);
                                header("Location: /home");
                            }
                            if ($macAddress != $getMACAddress)
                            {
                                header("Location: /authentication");
                            }
                        }else {
                            $newSession = array(
                                'email'             => $email,
                                'sessionID'         => $sessionID,
                                'created'           => time(),
                                'timeStart'         => time(),
                                'timeEnd'           => '',
                                'macAddress'        => $macAddress,
                                'externalIpAddress' => $ipAddress,
                                'status'            => 'Active',
                            );
                            $this->Sessions->create($newSession);
                            header("Location: /home");
                        }

                    }
                }else {
                    F3::set('MsgSignIn','Your password is incorrect');
                    $this->render('user/signUp.php', 'default');
                }
            }else {
                F3::set('MsgSignIn','Your email is not exist. Please sign up !');
                $this->render('user/signUp.php', 'default');
            }
        }
    }

    public function authentication()
    {
        $this->layout   = 'index';
        $email          = F3::get("POST.email");
        if ($email)
        {
            $existEmail = $this->User->findOne("email = ?", array($email));
            if ($this->ValidateHelper->validation($email, $existEmail, true) == '')
            {
                $code 	= $this->StringHelper->generateRandomString(5);
                setcookie('codeConfirmUser', $code, time()+3600);
                setcookie('email', $email, time()+3600);
                $this->EmailHelper->sendCodeConfirmEmail($email, $code);
                F3::set('email', $email);
                $this->render("user/confirmCode.php",'default');
            }else {
                F3::set('MsgValidate', $this->ValidateHelper->validation($email, $existEmail, true));
                $this->render("user/authentication.php",'default');
            }
        }else
            $this->render("user/authentication.php",'default');
    }

    public function confirmCode()
    {
        $this->layout   = 'index';
        $codeAuthEmail  = F3::get('POST.codeAuthEmail');
        if($codeAuthEmail ==  $_COOKIE["codeConfirmUser"])
        {
            $email      = $_COOKIE["email"];
            $existUser  = $this->User->findOne("email = ? AND role = ?", array($email, 'user'));
            if ($existUser)
            {
                F3::clear('SESSION');
                F3::set('SESSION.loggedUser', $existUser);
                //unset cookie
                setcookie('codeConfirmUser','',time()-3600);
                setcookie('email','',time()-3600);
                //continue using
                $sessionID      = rand(1000,10000000);
                $macAddress     = $this->getMacAddress();
                $ipAddress      = $this->getIPAddress();
                $currentUser    = array(
                    'timeEnd'   => time(),
                    'status'    => 'Disable',
                );
                $disableSession = $this->Sessions->updateByCondition($currentUser,"email = ? AND status = ? ",array($email, 'Active'));
                if ($disableSession)
                {
                    $newSession = array(
                        'email'				=> $email,
                        'sessionID'         => $sessionID,
                        'created'           => time(),
                        'timeStart'         => time(),
                        'timeEnd'           => '',
                        'macAddress'        => $macAddress,
                        'externalIpAddress' => $ipAddress,
                        'status'            => 'Active',
                    );
                    $this->Sessions->create($newSession);
                    header("Location:/home");
                }
            }
        }else {
            F3::set('MsgValidate','The code is incorrect. Please try again!');
            $this->render('user/confirmCode.php', 'default');
        }
    }

    public function forgotPassword()
    {
        $this->layout   = 'index';

        $email          = F3::get('POST.email');
        if ($email)
        {
            $isUsedEmail = $this->User->findOne("email = ?", array($email));
            if ($this->ValidateHelper->validation($email , $isUsedEmail, true) == '')
            {
                F3::set('user',$isUsedEmail);
                $this->render('user/resetPassword.php', 'default');
            }else {
                F3::set('MsgValidate',$this->ValidateHelper->validation($email, $isUsedEmail, true));
                $this->render('user/forgotPassword.php', 'default');
            }
        }else
            $this->render('user/forgotPassword.php', 'default');
    }

    public function resetPassword()
    {
        $this->layout   = 'index';
        $email          = F3::get('POST.email');
        if($email)
        {
            $codeConfirmPass= $this->StringHelper->generateRandomString(5);
            setcookie('codeConfirmPass',$codeConfirmPass,time()+3600);
            setcookie('email',$email,time()+3600);
            $this->EmailHelper->sendCodeConfirmPass($email, $codeConfirmPass);
        }
        F3::set('email',$email);
        $this->render('user/confirmPassword.php','default');
    }

    public function confirmPassword()
    {
        $this->layout   = 'index';

        $email          = $_COOKIE["email"];
        $codeConfirmPass= $_COOKIE["codeConfirmPass"];
        $getCode        = F3::get('POST.confirmCode');
        if ($email && $codeConfirmPass && $getCode)
        {
            if($getCode == $codeConfirmPass)
            {
                setcookie('codeConfirmPass','',time()-3600);
                $this->render('user/newPassword.php','default');
            }else {
                F3::set('MsgValidate','The code is not correct!');
                $this->render('user/confirmPassword.php','default');
            }
        }else
            $this->render('user/forgotPassword.php','default');
    }

    public function newPassword()
    {
        $email  = $_COOKIE['email'];
        $pWord  = F3::get('POST.password');
        $rePW   = F3::get('POST.re_password');
        if ($email && $pWord && $rePW)
        {
            if ($pWord == $rePW)
            {
                $hashPWord  = $this->EncryptionHelper->HashPassword($pWord);
                $updatePWord= array(
                    'password'  => $hashPWord
                );
                $this->User->updateByCondition($updatePWord, "email = ? AND role = ?", array($email, 'user'));
                $user = $this->User->findOne("email = ? AND role = ?", array($email, 'user'));
                if ($user)
                {
                    setcookie($email, '', time()-3600);
                    if ($user->data->status == 'pending')
                    {
                        F3::set('MsgValidate', 'Reset password is success. However you still not confirm this account, we had sent an link confirmation email to you!');
                        $this->render('user/newPassword.php','default');
                    }else {
                        F3::clear('SESSION');
                        F3::set('SESSION.loggedUser', $user);
                        $email = $user->data->email;
                        // start initial sessions.
                        $sessionID          = rand(1000,10000000);
                        $macAddress         = $this->getMacAddress();
                        $ipAddress          = $this->getIPAddress();
                        $existSessionUser   = $this->Sessions->findOne("email = ? AND status = ?", array($email, 'Active'));
                        //Will not check mac address same login func because it's high priority after reset password
                        if($existSessionUser)
                        {
                            //update status for current session
                            $currentSession = array(
                                'timeEnd'   	=> time(),
                                'status'    	=> 'Disable',
                            );
                            $this->Sessions->updateByCondition($currentSession,"email = ? AND status = ? ",array($email,'Active'));
                            //then create new session
                            $newSession = array(
                                'email'             => $email,
                                'sessionID'         => $sessionID,
                                'created'           => time(),
                                'timeStart'         => time(),
                                'timeEnd'           => '',
                                'macAddress'        => $macAddress,
                                'externalIpAddress' => $ipAddress,
                                'status'            => 'Active',
                            );
                            $this->Sessions->create($newSession);
                            header("Location: /home");
                        }else {
                            //create new session
                            $newSession = array(
                                'email'             => $email,
                                'sessionID'         => $sessionID,
                                'created'           => time(),
                                'timeStart'         => time(),
                                'timeEnd'           => '',
                                'macAddress'        => $macAddress,
                                'externalIpAddress' => $ipAddress,
                                'status'            => 'Active',
                            );
                            $this->Sessions->create($newSession);
                            header("Location: /home");
                        }
                    }
                }
            }else {
                F3::set('MsgValidate','Two password does not match!');
                $this->render('user/newPassword.php','default');
            }
        }else
            $this->render('user/forgotPassword.php','default');
    }

    public function logout()
    {
        $currentUser    = F3::get('SESSION.loggedUser');
        $currentSession = array(
            'timeEnd'=> time(),
            'status' => 'Disable',
        );
        $this->Sessions->updateByCondition($currentSession,'email = ? AND status = ?',array($currentUser->data->email, 'Active'));
        F3::clear("SESSION");
        setcookie('email','',time()-3600);
        setcookie('password','',time()-3600);
        header("Location:/");
    }
}
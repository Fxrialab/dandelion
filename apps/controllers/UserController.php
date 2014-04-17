<?php
class UserController extends AppController
{
    protected $helpers = array("Encryption", "Validate", "Email", "String", "Time");

    public function __construct()
    {
        parent::__construct();
    }

    public function signUp()
    {
        $this->layout = 'index';
        //get and prepare data for sign up
        $data = $this->f3->get('POST');

        if (isset($data['emailSignUp']))
        {
            $userModel = Model::get('user');
            //check email field has existed in DB
            $isUsedEmail = $this->facade->findByAttributes("user", array('email'=>$data["emailSignUp"]));
            //data is alright, create new user then send confirmation code to email
            if ($this->ValidateHelper->validation($data, $isUsedEmail, false) == '')
            {
                if (isset($data['regCheckbox']))
                {
                    // prepare birthday data
                    $data['firstName'] = strtolower($data['firstName']);
                    $data['lastName'] = strtolower($data['lastName']);
                    $data['email'] = $data['emailSignUp'];
                    // encrypt password
                    $data['password'] = $this->EncryptionHelper->HashPassword($data["pwSignUp"]);
                    $data['fullName'] = strtolower($data['firstName']) . " " . strtolower($data['lastName']);
                    $data['birthday'] = date("F-d-Y", mktime(0, 0, 0, $data['birthdayMonth'], $data['birthdayDay'], $data['birthdayYear']));
                    // set username for friends can view your profile using the link
                    $data['username'] = substr($data["emailSignUp"], 0, strpos($data["emailSignUp"], '@'));
                    // set default avatar
                    $data['profilePic'] = ($data['sex'] == 'female') ? IMAGES . "avatarWomenDefault.png" : IMAGES . "avatarMenDefault.png";
                    // set signUp status
                    $data['status'] = 'pending';
                    $data['role'] = 'user';
                    // and create time
                    $data['created'] = time();
                    //generate confirmation code
                    $confirmationCode = $this->StringHelper->generateRandomString(32);
                    $data['confirmationCode'] = $confirmationCode;
                    // valid in 24 hours
                    $confirmationCodeValidUntil = $this->TimeHelper->getTommorrow();
                    $data['confirmationCodeValidUntil'] = $confirmationCodeValidUntil;

                    //unset some data dont need
                    unset($data['sex']);
                    unset($data['emailSignUp']);
                    unset($data['pwSignUp']);
                    unset($data['birthdayDay']);
                    unset($data['birthdayMonth']);
                    unset($data['birthdayYear']);
                    unset($data['regCheckbox']);
                    unset($data['smSignUp']);
                    // exclude form submit button and checkbox from data and create a new user
                    $userRC = $this->facade->save('user', $data);
                    // add user info to class
                    $infoData = array(
                        'user' => $userRC,
                        'gender' => $this->f3->get('POST.sex')
                    );
                    $this->facade->save('information',$infoData);
                    // set default permission for user
                    $permissionDefault = array(
                        'user' => $userRC,
                        'gender' => 'globe'
                    );
                    $this->facade->save('permission',$permissionDefault);
                    // sent mail for confirmation account
                    $this->EmailHelper->sendConfirmationEmail($data['email'], $confirmationCode);
                    $this->f3->set('MsgSignUp', 'You are registered success. Please check mail and confirm !');
                    $this->render('user/index.php', 'default');
                } else {
                    $this->f3->set('MsgSignUp', 'Please agree to the Terms and Privacy Policy');
                    $this->render('user/index.php', 'default');
                }
            } else {
                $this->f3->set('MsgSignUp', $this->ValidateHelper->validation($data, $isUsedEmail, false));
                $this->render('user/index.php', 'default');
            }
        }
    }

    public function confirm()
    {
        //Set layout default
        $this->layout   = 'index';
        $request    = $this->f3->get('GET');
        $email      = $request['email'];
        $confirmationCode = $request['confirmationCode'];
        if ($email && $confirmationCode)
        {
            $user = $this->facade->findByAttributes('user', array('email'=>$email));
            if ($user->data->confirmationCode != 'none')
            {
                if (($user->data->confirmationCode == $confirmationCode) /* &&
                  (time() <= $user->data->confirmationCodeValidUntil) */
                ) {
                    // change status
                    $user->data->status = 'confirmed';
                    // reset confirmation info
                    $user->data->confirmationCode = 'none';
                    $user->data->confirmationCodeValidUntil = 'none';
                    $this->facade->updateByPk('user', $user->recordID, $user);
                    /* Create notify for user */
                    $notify = array(
                        'userID' => $user->recordID,
                        'notify' => 0,
                        'requestFriend' => 0,
                        'message' => 0
                    );
                    $this->facade->save('notify', $notify);
                    $this->f3->set('MsgSignIn', 'Thank you confirm email. Now, you can login !');
                    $this->render('user/index.php', 'default');
                } else {
                    $this->f3->set('MsgSignIn', 'The confirmation code or email are incorrect. Please, try check mail again !');
                    $this->render('user/index.php', 'default');
                }
            }
        }
    }

    public function login()
    {
        $this->layout = 'index';
        $request = $this->f3->get('POST');
        if (!empty($request))
        {
            $email      = $request['emailLogIn'];
            $password   = $request['pwLogIn'];
            $existUser  = $this->facade->findByAttributes('user', array('email'=>$email,'role'=>'user'));
            if (!empty($existUser))
            {
                if ($this->EncryptionHelper->CheckPassword($password, $existUser->data->password))
                {
                    //Check status of user. If status='pending' must enter confirm code
                    if ($existUser->data->status == 'pending') {
                        $this->f3->set('MsgSignIn', 'We have sent an confirmation email to you. Please check the email and confirm your email with us !');
                        $this->render('user/index.php', 'default');
                    } else {
                        if (isset($request['persistent']) == true) {
                            setcookie('email', $email, time() + 7 * 24 * 60 * 60);
                            setcookie('password', $password, time() + 7 * 24 * 60 * 60);
                        } else {
                            setcookie('email', $email, time() - 3600);
                            setcookie('password', $password, time() - 3600);
                        }
//                        $this->f3->clear('SESSION');
                        $this->f3->set('SESSION.loggedUser', $existUser);
                        $this->f3->set('SESSION.username',$existUser->data->username);
                        $this->f3->set('SESSION.email',$existUser->data->email);
                        $this->f3->set('SESSION.fullname',$existUser->data->fullName);
                        $this->f3->set('SESSION.birthday',$existUser->data->birthday);
                        $this->f3->set('SESSION.avatar', $existUser->data->profilePic);
                        $this->f3->set('SESSION.userID', $existUser->recordID);
                        // start initial sessions.
                        $sessionID  = rand(1000, 10000000);
                        $macAddress = $this->getMacAddress();
                        $ipAddress  = $this->getIPAddress();
                        $existSessionUser = $this->facade->findByAttributes('sessions', array('email'=>$email, 'status'=>'Active'));

                        if ($existSessionUser) {
                            $getMACAddress = $existSessionUser->data->macAddress;
                            if ($macAddress == $getMACAddress) {
                                //update status for current session
                                $currentSession = array(
                                    'timeEnd' => time(),
                                    'status' => 'Disable',
                                );
                                $this->facade->updateByAttributes('sessions', $currentSession, array('email'=>$email, 'status'=>'Active'));
                                //then create new session
                                $newSession = array(
                                    'email' => $email,
                                    'sessionID' => $sessionID,
                                    'created' => time(),
                                    'timeStart' => time(),
                                    'timeEnd' => '',
                                    'macAddress' => $macAddress,
                                    'externalIpAddress' => $ipAddress,
                                    'status' => 'Active',
                                );
                                $this->facade->save('sessions', $newSession);
                                header("Location: /home");
                            }
                            if ($macAddress != $getMACAddress) {
                                header("Location: /authentication");
                            }
                        } else {
                            $newSession = array(
                                'email' => $email,
                                'sessionID' => $sessionID,
                                'created' => time(),
                                'timeStart' => time(),
                                'timeEnd' => '',
                                'macAddress' => $macAddress,
                                'externalIpAddress' => $ipAddress,
                                'status' => 'Active',
                            );
                            $this->facade->save('sessions',$newSession);
                            header("Location: /home");
                        }
                    }
                } else {
                    $this->f3->set('MsgSignIn', 'Your password is incorrect');
                    $this->render('user/index.php', 'default');
                }
            } else {
                $this->f3->set('MsgSignIn', 'Your email is not exist. Please sign up !');
                $this->render('user/index.php', 'default');
            }
        } else {
            $this->render('user/index.php', 'default');
        }
    }

    public function authentication()
    {
        $this->layout = 'index';
        $email = $this->f3->get("POST.email");
        if ($email) {
            $existEmail = $this->facade->findByAttributes('user', array('email'=>$email));
            if ($this->ValidateHelper->validation($email, $existEmail, true) == '') {
                $code = $this->StringHelper->generateRandomString(5);
                setcookie('codeConfirmUser', $code, time() + 3600);
                setcookie('email', $email, time() + 3600);
                $this->EmailHelper->sendCodeConfirmEmail($email, $code);
                $this->f3->set('email', $email);
                $this->render("user/confirmCode.php", 'default');
            } else {
                $this->f3->set('MsgValidate', $this->ValidateHelper->validation($email, $existEmail, true));
                $this->render("user/authentication.php", 'default');
            }
        } else
            $this->render("user/authentication.php", 'default');
    }

    public function confirmCode()
    {
        $this->layout = 'index';
        $codeAuthEmail = $this->f3->get('POST.codeAuthEmail');
        if ($codeAuthEmail == $_COOKIE["codeConfirmUser"]) {
            $email = $_COOKIE["email"];
            $existUser = $this->facade->findByAttributes('user', array('email'=>$email, 'role'=>'user'));
            if ($existUser) {
                $this->f3->clear('SESSION');
                $this->f3->set('SESSION.loggedUser', $existUser);
                //unset cookie
                setcookie('codeConfirmUser', '', time() - 3600);
                setcookie('email', '', time() - 3600);
                //continue using
                $sessionID = rand(1000, 10000000);
                $macAddress = $this->getMacAddress();
                $ipAddress = $this->getIPAddress();
                $currentUser = array(
                    'timeEnd' => time(),
                    'status' => 'Disable',
                );
                $disableSession = $this->facade->updateByAttributes('sessions', $currentUser, array('email'=>$email, 'status'=>'Active'));
                if ($disableSession) {
                    $newSession = array(
                        'email' => $email,
                        'sessionID' => $sessionID,
                        'created' => time(),
                        'timeStart' => time(),
                        'timeEnd' => '',
                        'macAddress' => $macAddress,
                        'externalIpAddress' => $ipAddress,
                        'status' => 'Active',
                    );
                    $this->facade->save('sessions', $newSession);
                    header("Location:/home");
                }
            }
        } else {
            $this->f3->set('email', $_COOKIE["email"]);
            $this->f3->set('MsgValidate', 'The code is incorrect. Please try again!');
            $this->render('user/confirmCode.php', 'default');
        }
    }

    public function forgotPassword()
    {
        $this->layout = 'index';

        $email = $this->f3->get('POST.email');
        if ($email) {
            $isUsedEmail = $this->facade->findByAttributes('user', array('email'=>$email));
            if ($this->ValidateHelper->validation($email, $isUsedEmail, true) == '') {
                $this->f3->set('profileName', ucfirst($isUsedEmail->data->firstName) . ' ' . ucfirst($isUsedEmail->data->lastName));
                $this->f3->set('user', $isUsedEmail);
                $this->render('user/resetPassword.php', 'default');
            } else {
                $this->f3->set('MsgValidate', $this->ValidateHelper->validation($email, $isUsedEmail, true));
                $this->render('user/forgotPassword.php', 'default');
            }
        } else
            $this->render('user/forgotPassword.php', 'default');
    }

    public function resetPassword()
    {
        $this->layout = 'index';
        $email = $this->f3->get('POST.email');
        if ($email) {
            $codeConfirmPass = $this->StringHelper->generateRandomString(5);
            setcookie('codeConfirmPass', $codeConfirmPass, time() + 3600);
            setcookie('email', $email, time() + 3600);
            $this->EmailHelper->sendCodeConfirmPass($email, $codeConfirmPass);
        }
        $this->f3->set('email', $email);
        $this->render('user/confirmPassword.php', 'default');
    }

    public function confirmPassword()
    {
        $this->layout = 'index';

        $email = $_COOKIE["email"];
        $codeConfirmPass = $_COOKIE["codeConfirmPass"];
        $getCode = $this->f3->get('POST.confirmCode');
        if ($email && $codeConfirmPass && $getCode) {
            if ($getCode == $codeConfirmPass) {
                setcookie('codeConfirmPass', '', time() - 3600);
                $this->render('user/newPassword.php', 'default');
            } else {
                $this->f3->set('email', $email);
                $this->f3->set('MsgValidate', 'The code is not correct!');
                $this->render('user/confirmPassword.php', 'default');
            }
        } else
            $this->render('user/forgotPassword.php', 'default');
    }

    public function newPassword()
    {
        $this->layout = 'index';

        $email = $_COOKIE['email'];
        $pWord = $this->f3->get('POST.pWord');
        $rePW = $this->f3->get('POST.rePWord');
        if ($email && $pWord && $rePW)
        {
            if ($pWord == $rePW)
            {
                $hashPWord = $this->EncryptionHelper->HashPassword($pWord);
                $updatePWord = array(
                    'password' => $hashPWord
                );
                $this->facade->updateByAttributes('user', $updatePWord, array('email'=>$email, 'role'=>'user'));
                $user = $this->facade->findByAttributes('user', array('email'=>$email, 'role'=>'user'));
                if ($user)
                {
                    setcookie($email, '', time() - 3600);
                    if ($user->data->status == 'pending')
                    {
                        $this->f3->set('MsgValidate', 'Reset password is success. However you still not confirm this account, we had send an link confirmation email to you!');
                        $this->render('user/newPassword.php', 'default');
                    } else {
                        $this->f3->clear('SESSION');
                        $this->f3->set('SESSION.loggedUser', $user);
                        $email = $user->data->email;
                        // start initial sessions.
                        $sessionID = rand(1000, 10000000);
                        $macAddress = $this->getMacAddress();
                        $ipAddress = $this->getIPAddress();
                        $existSessionUser = $this->facade->findByAttributes('sessions', array('email'=>$email, 'status'=>'Active'));
                        //Will not check mac address same login func because it's high priority after reset password
                        if ($existSessionUser) {
                            //update status for current session
                            $currentSession = array(
                                'timeEnd' => time(),
                                'status' => 'Disable',
                            );
                            $this->facade->updateByAttributes('sessions', $currentSession, array('email'=>$email, 'status'=>'Active'));
                            //then create new session
                            $newSession = array(
                                'email' => $email,
                                'sessionID' => $sessionID,
                                'created' => time(),
                                'timeStart' => time(),
                                'timeEnd' => '',
                                'macAddress' => $macAddress,
                                'externalIpAddress' => $ipAddress,
                                'status' => 'Active',
                            );
                            $this->facade->save('sessions', $newSession);
                            header("Location: /home");
                        } else {
                            //create new session
                            $newSession = array(
                                'email' => $email,
                                'sessionID' => $sessionID,
                                'created' => time(),
                                'timeStart' => time(),
                                'timeEnd' => '',
                                'macAddress' => $macAddress,
                                'externalIpAddress' => $ipAddress,
                                'status' => 'Active',
                            );
                            $this->facade->save('sessions', $newSession);
                            header("Location: /home");
                        }
                    }
                }
            } else {
                $this->f3->set('MsgValidate', 'Two password does not match!');
                $this->render('user/newPassword.php', 'default');
            }
        } else
            $this->render('user/forgotPassword.php', 'default');
    }

    public function logout()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->f3->get('SESSION.loggedUser');
            $currentSession = array(
                'timeEnd' => time(),
                'status' => 'Disable',
            );
            $this->facade->updateByAttributes('sessions', $currentSession, array('email'=>$currentUser->data->email, 'status'=>'Active'));
            $this->f3->clear("SESSION");
            setcookie('email', '', time() - 3600);
            setcookie('password', '', time() - 3600);
            header("Location:/");
        }
    }

    public function about()
    {
        if ($this->isLogin()) {
            $this->layout = "other";


            //set currentUser and otherUser for check in profile element and header
            $this->f3->set('currentUser', $this->getCurrentUser());
            $this->f3->set('otherUser', $this->getCurrentUser());
            $this->render('user/about.php', 'default');
        }
    }

    public function loadBasicInfo()
    {
        if ($this->isLogin()) {
            $gender = $this->f3->get('POST.gender');
            $interest = $this->f3->get('POST.interest');
            $relation = $this->f3->get('POST.relation');
            $day = $this->f3->get('POST.day');
            $month = $this->f3->get('POST.month');
            $year = $this->f3->get('POST.year');
            $birthDayStatus = $this->f3->get('POST.birthDayStatus');
            $birthYearStatus = $this->f3->get('POST.birthYearStatus');
            $genderStatus = $this->f3->get('POST.genderStatus');
            $interestStatus = $this->f3->get('POST.interestStatus');
            $relationStatus = $this->f3->get('POST.relationStatus');

            if ($gender && $interest && $relation && $day && $month && $year &&
                $birthDayStatus && $birthYearStatus && $genderStatus && $interestStatus && $relationStatus
            ) {
                //set basic info to edit popUpOver
                $this->f3->set('month', $month);
                $this->f3->set('day', $day);
                $this->f3->set('year', $year);
                $this->f3->set('gender', $gender);
                $this->f3->set('relation', $relation);
                $this->f3->set('interest', $interest);
                $this->f3->set('birthDayStatus', $birthDayStatus);
                $this->f3->set('birthYearStatus', $birthYearStatus);
                $this->f3->set('genderStatus', $genderStatus);
                $this->f3->set('interestStatus', $interestStatus);
                $this->f3->set('relationStatus', $relationStatus);

                $this->render('user/editBasicInfo.php', 'default');
            }
        }
    }

    public function editBasicInfo()
    {
        if ($this->isLogin()) {
            $currentUser = $this->f3->get('SESSION.loggedUser');
            $month = $this->f3->get('POST.change_Month');
            $day = $this->f3->get('POST.change_Day');
            $year = $this->f3->get('POST.change_Year');
            $birthday = $month . "-" . $day . "-" . $year;

            $updateUserClass = array(
                'birthday' => $birthday
            );
            Model::get('user')->updateByCondition($updateUserClass, 'email = ?', array($currentUser->data->email));

            $gender = $this->f3->get('POST.gender');
            $interest = $this->f3->get('POST.interest');
            $relation = $this->f3->get('POST.relation');

            $updateInfoClass = array(
                'gender' => $gender,
                'interest' => ($interest) ? $interest : 'none',
                'relation' => ($relation) ? $relation : 'none',
            );
            $this->Information->updateByCondition($updateInfoClass, 'user = ?', array($currentUser->recordID));
        }
    }

    public function loadEduWork()
    {
        if ($this->isLogin()) {
            $currentUser = $this->f3->get('SESSION.loggedUser');
            $work = $this->f3->get('POST.work');

            $findWorkID = $this->Information->findOne('user = ?', array($currentUser->recordID));
            //var_dump($findWorkID->data->work[0]);
            foreach ($findWorkID->data->work as $workID) {
                $id = $workID->clusterID . ":" . $workID->recordPos;
                $findWork[$id] = $this->Work->sqlGremlin("current.map", "@rid = ?", array('#' . $workID));
            }
            //var_dump($findWork);
            if ($work) {
                $workRC = array(
                    'workName' => $work,
                    'work' => str_replace(' ', '', $work),
                    'ofUser' => $currentUser->recordID
                );
                $this->Work->create($workRC);
                $this->Work->createLink('work', 'LINKSET', 'work.ofUser', 'information.user');
            }
            $this->f3->set('works', $findWorkID);
            $this->f3->set('findWork', $findWork);
            $this->render('user/editEduWork.php', 'default');
        }
    }

    public function searchWork()
    {
        if ($this->isLogin()) {
            $workIs = $this->f3->get('POST.workIs');
            $data = array(
                'results' => array(),
                'success' => false,
                'new' => ''
            );
            $command = $this->getSearchCommand(array('workName', 'work'), $workIs);
            //echo $command;
            $result = $this->Work->searchByGremlin($command);

            if ($result) {
                //var_dump($result);
                foreach ($result as $work) {
                    $infoWork[$work] = $this->Work->sqlGremlin("current.map", "@rid = ?", array('#' . $work));
                    //var_dump($infoWork);
                    $data['results'][] = array(
                        'workName' => ucfirst($infoWork[$work][0]->workName)
                    );
                }
                $data['success'] = true;
            } else {
                $data['new'] = $workIs;
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode((object)$data);
            //$this->render('user/editEduWork.php', 'default');
        }
    }

}
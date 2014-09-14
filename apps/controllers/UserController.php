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
            //check email field has existed in DB
            $isUsedEmail = $this->facade->findByAttributes("user", array('email' => $data["emailSignUp"]));
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
                    $data['profilePic'] = 'none';
                    // set signUp status
                    $data['status'] = 'pending';
                    $data['role'] = 'user';
                    $data['coverPhoto'] = 'none';
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
                    $this->facade->save('information', $infoData);
                    // set default permission for user
                    $permissionDefault = array(
                        'user' => $userRC,
                        'gender' => 'globe'
                    );
                    $this->facade->save('permission', $permissionDefault);
                    // sent mail for confirmation account
                    $this->EmailHelper->sendConfirmationEmail($data['email'], $confirmationCode);
                    $this->render('user/index.php', 'default', array(
                        'msgSignUp' => 'You are registered success. Please check mail and confirm !'
                    ));
                }
                else
                {
                    $this->render('user/index.php', 'default', array(
                        'msgSignUp' => 'Please agree to the Terms and Privacy Policy'
                    ));
                }
            }
            else
            {
                $this->render('user/index.php', 'default', array(
                    'msgSignUp' => $this->ValidateHelper->validation($data, $isUsedEmail, false)
                ));
            }
        }
    }

    public function confirm()
    {
        //Set layout default
        $this->layout = 'index';
        $request = $this->f3->get('GET');
        $email = $request['email'];
        $confirmationCode = $request['confirmationCode'];
        if ($email && $confirmationCode)
        {
            $user = $this->facade->findByAttributes('user', array('email' => $email));
            if ($user->data->confirmationCode != 'none')
            {
                if (($user->data->confirmationCode == $confirmationCode) /* &&
                  (time() <= $user->data->confirmationCodeValidUntil) */
                )
                {
                    // change status
                    $user->data->status = 'confirmed';
                    // reset confirmation info
                    $user->data->confirmationCode = 'none';
                    $user->data->confirmationCodeValidUntil = 'none';
                    $this->facade->updateByPk('user', $user->recordID, $user);
                    /* Create notify for user */
                    $notify = array(
                        'userID' => $user->recordID,
                        'notifications' => 0,
                        'friendRequests' => 0,
                        'message' => 0
                    );
                    $this->facade->save('notify', $notify);
                    $this->render('user/index.php', 'default', array(
                        'msgSignIn' => 'Thank you confirm email. Now, you can login !'
                    ));
                }
                else
                {
                    $this->render('user/index.php', 'default', array(
                        'msgSignIn' => 'The confirmation code or email are incorrect. Please, try check mail again !'
                    ));
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
            $email = $request['emailLogIn'];
            $password = $request['pwLogIn'];
            $existUser = $this->facade->findByAttributes('user', array('email' => $email, 'role' => 'user'));
            if (!empty($existUser))
            {
                if ($this->EncryptionHelper->CheckPassword($password, $existUser->data->password))
                {
                    //Check status of user. If status='pending' must enter confirm code
                    if ($existUser->data->status == 'pending')
                    {
                        $this->f3->set('MsgSignIn', 'We have sent an confirmation email to you. Please check the email and confirm your email with us !');
                        $this->render('user/index.php', 'default');
                    }
                    else
                    {
                        if (isset($request['persistent']) == true)
                        {
                            setcookie('email', $email, time() + 7 * 24 * 60 * 60);
                            setcookie('password', $password, time() + 7 * 24 * 60 * 60);
                        }
                        else
                        {
                            setcookie('email', $email, time() - 3600);
                            setcookie('password', $password, time() - 3600);
                        }
                        //$this->f3->clear('SESSION');
                        if ($existUser->data->profilePic != 'none')
                        {
                            $photo = $this->facade->findByPk('photo', $existUser->data->profilePic);
                            $profilePic = UPLOAD_URL . "avatar/170px/" . $photo->data->fileName;
                        }else {
                            $gender = HelperController::findGender($existUser->recordID);
                            if ($gender == 'male')
                                $profilePic = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                            else
                                $profilePic = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
                        }
                        $fullName = ucfirst($existUser->data->firstName)." ".ucfirst($existUser->data->lastName);
                        $this->f3->set('SESSION.loggedUser', $existUser);
                        $this->f3->set('SESSION.username', $existUser->data->username);
                        $this->f3->set('SESSION.firstname', ucfirst($existUser->data->firstName));
                        $this->f3->set('SESSION.email', $existUser->data->email);
                        $this->f3->set('SESSION.fullname', $fullName);
                        $this->f3->set('SESSION.birthday', $existUser->data->birthday);
                        $this->f3->set('SESSION.avatar', $profilePic);
                        $this->f3->set('SESSION.userID', $existUser->recordID);
                        // start initial sessions.
                        $sessionID = rand(1000, 10000000);
                        $macAddress = $this->getMacAddress();
                        $ipAddress = $this->getIPAddress();
                        $existSessionUser = $this->facade->findByAttributes('sessions', array('email' => $email, 'status' => 'Active'));

                        if (!empty($existSessionUser))
                        {
                            $getMACAddress = $existSessionUser->data->macAddress;
                            if ($macAddress == $getMACAddress)
                            {
                                //update status for current session
                                $currentSession = array(
                                    'timeEnd' => time(),
                                    'status' => 'Disable',
                                );
                                $this->facade->updateByAttributes('sessions', $currentSession, array('email' => $email, 'status' => 'Active'));
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
                            if ($macAddress != $getMACAddress)
                            {
                                header("Location: /authentication");
                            }
                        }
                        else
                        {
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
                else
                {
                    $this->render('user/index.php', 'default', array(
                        'msgSignIn' => 'Your password is incorrect'
                    ));
                }
            }
            else
            {
                $this->render('user/index.php', 'default', array(
                    'msgSignIn' => 'Your email is not exist. Please sign up !'
                ));
            }
        }
        else
        {
            $this->render('user/index.php', 'default');
        }
    }

    public function authentication()
    {
        $this->layout = 'index';
        $email = $this->f3->get("POST.email");
        if (!empty($email))
        {
            $existEmail = $this->facade->findByAttributes('user', array('email' => $email));
            if ($this->ValidateHelper->validation($email, $existEmail, true) == '')
            {
                $code = $this->StringHelper->generateRandomString(5);
                setcookie('codeConfirmUser', $code, time() + 3600);
                setcookie('email', $email, time() + 3600);
                $this->EmailHelper->sendCodeConfirmEmail($email, $code);
                $this->render("user/confirmCode.php", 'default', array('email' => $email));
            }
            else
            {
                $this->render("user/authentication.php", 'default', array(
                    'MsgValidate'   => $this->ValidateHelper->validation($email, $existEmail, true)
                ));
            }
        }
        else
            $this->render("user/authentication.php", 'default');
    }

    public function confirmCode()
    {
        $this->layout = 'index';
        $codeAuthEmail = $this->f3->get('POST.codeAuthEmail');
        if ($codeAuthEmail == $_COOKIE["codeConfirmUser"])
        {
            $email = $_COOKIE["email"];
            $existUser = $this->facade->findByAttributes('user', array('email' => $email, 'role' => 'user'));
            if (!empty($existUser))
            {
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
                $disableSession = $this->facade->updateByAttributes('sessions', $currentUser, array('email' => $email, 'status' => 'Active'));
                if ($disableSession)
                {
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
        }
        else
        {
            $this->render('user/confirmCode.php', 'default', array(
                'email' => $_COOKIE["email"],
                'msgValidate' => 'The code is incorrect. Please try again!'
            ));
        }
    }

    public function forgotPassword()
    {
        $this->layout = 'index';

        $email = $this->f3->get('POST.email');
        if (!empty($email))
        {
            $isUsedEmail = $this->facade->findByAttributes('user', array('email' => $email));
            if ($this->ValidateHelper->validation($email, $isUsedEmail, true) == '')
            {
                $this->render('user/resetPassword.php', 'default', array(
                    'user' => $isUsedEmail
                ));
            }
            else
            {
                $this->render('user/forgotPassword.php', 'default', array(
                    'msgValidate'   => $this->ValidateHelper->validation($email, $isUsedEmail, true)
                ));
            }
        }
        else
            $this->render('user/forgotPassword.php', 'default');
    }

    public function resetPassword()
    {
        $this->layout = 'index';
        $email = $this->f3->get('POST.email');
        if (!empty($email))
        {
            $codeConfirmPass = $this->StringHelper->generateRandomString(5);
            setcookie('codeConfirmPass', $codeConfirmPass, time() + 3600);
            setcookie('email', $email, time() + 3600);
            $this->EmailHelper->sendCodeConfirmPass($email, $codeConfirmPass);
            $this->render('user/confirmPassword.php', 'default', array('email'=>$email));
        }else {
            $this->render('user/resetPassword.php', 'default');
        }

    }

    public function confirmPassword()
    {
        $this->layout = 'index';

        $getCode = $this->f3->get('POST.confirmCode');
        if (!empty($_COOKIE["email"]) && !empty($_COOKIE["codeConfirmPass"]) && !empty($getCode))
        {
            $email = $_COOKIE["email"];
            $codeConfirmPass = $_COOKIE["codeConfirmPass"];

            if ($getCode == $codeConfirmPass)
            {
                setcookie('codeConfirmPass', '', time() - 3600);
                $this->render('user/newPassword.php', 'default');
            }
            else
            {
                $this->render('user/confirmPassword.php', 'default', array(
                    'email' => $email,
                    'msgValidate'   => 'The code is not correct!'
                ));
            }
        }
        else
            $this->render('user/forgotPassword.php', 'default');
    }

    public function newPassword()
    {
        $this->layout = 'index';

        $pWord = $this->f3->get('POST.pWord');
        $rePW = $this->f3->get('POST.rePWord');
        if (!empty($_COOKIE['email']) && !empty($pWord) && !empty($rePW))
        {
            $email = $_COOKIE['email'];
            if ($pWord == $rePW)
            {
                $hashPWord = $this->EncryptionHelper->HashPassword($pWord);
                $updatePWord = array(
                    'password' => $hashPWord
                );
                $this->facade->updateByAttributes('user', $updatePWord, array('email' => $email, 'role' => 'user'));
                $user = $this->facade->findByAttributes('user', array('email' => $email, 'role' => 'user'));
                if (!empty($user))
                {
                    setcookie($email, '', time() - 3600);
                    if ($user->data->status == 'pending')
                    {
                        $this->render('user/newPassword.php', 'default', array(
                            'msgValidate'   => 'Reset password is success. However you still not confirm this account, we had send an link confirmation email to you!'
                        ));
                    }
                    else
                    {
                        $this->f3->clear('SESSION');
                        $this->f3->set('SESSION.loggedUser', $user);
                        $email = $user->data->email;
                        // start initial sessions.
                        $sessionID = rand(1000, 10000000);
                        $macAddress = $this->getMacAddress();
                        $ipAddress = $this->getIPAddress();
                        $existSessionUser = $this->facade->findByAttributes('sessions', array('email' => $email, 'status' => 'Active'));
                        //Will not check mac address same login func because it's high priority after reset password
                        if ($existSessionUser)
                        {
                            //update status for current session
                            $currentSession = array(
                                'timeEnd' => time(),
                                'status' => 'Disable',
                            );
                            $this->facade->updateByAttributes('sessions', $currentSession, array('email' => $email, 'status' => 'Active'));
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
                        else
                        {
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
            }
            else
            {
                $this->render('user/newPassword.php', 'default', array('msgValidate'=>'Two password does not match!'));
            }
        }
        else
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
            $this->facade->updateByAttributes('sessions', $currentSession, array('email' => $currentUser->data->email, 'status' => 'Active'));
            $this->f3->clear("SESSION");
            setcookie('email', '', time() - 3600);
            setcookie('password', '', time() - 3600);
            header("Location:/");
        }
    }

    public function about()
    {
        if ($this->isLogin())
        {
            $this->layout = "timeline";

            $username = $this->f3->get('GET.user');
            $currentUser = $this->getCurrentUser();
            $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $username));
            $currentProfileID = $currentProfileRC->recordID;
            //get status friendship
            $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
            //set currentUser and otherUser for check in profile element and header
            $this->f3->set('currentUser', $this->getCurrentUser());
            $this->f3->set('otherUser', $this->getCurrentUser());
            $this->f3->set('statusFriendShip', $statusFriendShip);
            $this->render('user/about.php', 'default');
        }
    }

    public function loadBasicInfo()
    {
        if ($this->isLogin())
        {
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
            )
            {
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
        if ($this->isLogin())
        {
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
        if ($this->isLogin())
        {
            $currentUser = $this->f3->get('SESSION.loggedUser');
            $work = $this->f3->get('POST.work');

            $findWorkID = $this->Information->findOne('user = ?', array($currentUser->recordID));
            //var_dump($findWorkID->data->work[0]);
            foreach ($findWorkID->data->work as $workID)
            {
                $id = $workID->clusterID . ":" . $workID->recordPos;
                $findWork[$id] = $this->Work->sqlGremlin("current.map", "@rid = ?", array('#' . $workID));
            }
            //var_dump($findWork);
            if ($work)
            {
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
        if ($this->isLogin())
        {
            $workIs = $this->f3->get('POST.workIs');
            $data = array(
                'results' => array(),
                'success' => false,
                'new' => ''
            );
            $command = $this->getSearchCommand(array('workName', 'work'), $workIs);
            //echo $command;
            $result = $this->Work->searchByGremlin($command);

            if ($result)
            {
                //var_dump($result);
                foreach ($result as $work)
                {
                    $infoWork[$work] = $this->Work->sqlGremlin("current.map", "@rid = ?", array('#' . $work));
                    //var_dump($infoWork);
                    $data['results'][] = array(
                        'workName' => ucfirst($infoWork[$work][0]->workName)
                    );
                }
                $data['success'] = true;
            }
            else
            {
                $data['new'] = $workIs;
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode((object) $data);
            //$this->render('user/editEduWork.php', 'default');
        }
    }

}
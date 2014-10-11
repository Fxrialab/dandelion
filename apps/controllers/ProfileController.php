<?php

class ProfileController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function about()
    {
        if ($this->isLogin())
        {
            $this->layout = "about";

            $username = $this->f3->get('GET.user');
            $currentUser = $this->getCurrentUser();
            $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $username));
            if (!empty($currentProfileRC))
            {
                $currentProfileID = $currentProfileRC->recordID;
                $information = $this->facade->findByAttributes('information', array('user' => $currentProfileID));
                //get status friendship
                $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
                //set currentUser and otherUser for check in profile element and header
                $this->f3->set('currentUser', $this->getCurrentUser());
                $this->f3->set('otherUser', $this->getCurrentUser());
                $this->f3->set('statusFriendShip', $statusFriendShip);
                $this->f3->set('userID', $this->f3->get('SESSION.userID'));
                $this->f3->set('profileID', $currentProfileID);
                switch ($_GET['section'])
                {
                    case 'overview':
                        $this->render('profile/overview.php', 'default', array('username' => $username, 'active' => 'overview', 'information' => $information));
                        break;
                    case 'education':
                        $this->render('profile/education.php', 'default', array('username' => $username, 'active' => 'education', 'information' => $information));
                        break;
                    case 'living':
                        $this->render('profile/living.php', 'default', array('username' => $username, 'active' => 'living', 'information' => $information));
                        break;
                    case 'contact':
                        $this->render('profile/contact.php', 'default', array('username' => $username, 'active' => 'contact', 'email' => $currentProfileRC->data->email, 'information' => $information));
                        break;
                    case 'relationship':
                        $this->render('profile/relationship.php', 'default', array('username' => $username, 'active' => 'relationship'));
                        break;
                    case 'bio':
                        $this->render('profile/bio.php', 'default', array('username' => $username, 'active' => 'bio', 'fullname' => $currentProfileRC->data->fullName, 'information' => $information));
                        break;
                    case 'year-overviews':
                        $this->render('profile/yearOverviews.php', 'default', array('username' => $username, 'active' => 'year-overviews'));
                        break;
                }
            }
        }
    }

    public function work()
    {
        if (!empty($_POST['infoID']))
        {
            $data = array(
                'position' => $_POST['position'],
                'work_location' => $_POST['city'],
                'work_description' => $_POST['work_description']
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editWork.php', 'default', array('information' => $information));
        }
    }

    public function college()
    {
        if (!empty($_POST['infoID']))
        {
            $data = array(
                'university' => $_POST['university'],
                'concentrations' => $_POST['concentrations']
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editCollege.php', 'default', array('information' => $information));
        }
    }

    public function school()
    {
        if (!empty($_POST['infoID']))
        {
            $data = array(
                'school' => $_POST['school'],
                'school_location' => $_POST['school_location']
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editSchool.php', 'default', array('information' => $information));
        }
    }

    public function currentCity()
    {
        if (!empty($_POST['infoID']))
        {
            $data = array(
                'current_city' => $_POST['current_city'],
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editCity.php', 'default', array('information' => $information));
        }
    }

    public function homeCity()
    {
        if (!empty($_POST['infoID']))
        {
            $data = array(
                'home_city' => $_POST['home_city'],
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editCity.php', 'default', array('information' => $information));
        }
    }

    public function contactPhone()
    {
        if (!empty($_POST['infoID']))
        {
            $data = array(
                'phone_mobile' => $_POST['phone_mobile'],
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editContactPhone.php', 'default', array('information' => $information));
        }
    }

    public function birthday()
    {
        if (!empty($_POST['infoID']))
        {
            $birthday = $_POST['month'] . '-' . $_POST['day'] . '-' . $_POST['year'];
            $data = array(
                'birthday' => $birthday,
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editBirthday.php', 'default', array('information' => $information));
        }
    }

    public function gender()
    {
        if (!empty($_POST['infoID']))
        {

            $data = array(
                'gender' => $_POST['gender'],
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editGender.php', 'default', array('information' => $information));
        }
    }

    public function editname()
    {
        if (!empty($_POST['firstName']) && !empty($_POST['lastName']))
        {
            $data = array(
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'fullName' => $_POST['firstName'] . ' ' . $_POST['lastName'],
            );
            $update = $this->facade->updateByAttributes('user', $data, array('@rid' => '#' . $this->f3->get('SESSION.userID')));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $user = $this->facade->findByAttributes('user', array('@rid' => '#' . $this->f3->get('SESSION.userID')));
            $this->render('profile/editName.php', 'default', array('firstName' => $user->data->firstName, 'lastName' => $user->data->lastName));
        }
    }

    public function editabout()
    {
        if (!empty($_POST['infoID']))
        {

            $data = array(
                'about' => $_POST['about'],
            );
            $update = $this->facade->updateByAttributes('information', $data, array('@rid' => '#' . $_POST['infoID']));
            if ($update != FALSE)
                echo json_encode($data);
        }
        else
        {
            $information = $this->facade->findByAttributes('information', array('user' => $this->f3->get('SESSION.userID')));
            $this->render('profile/editAbout.php', 'default', array('information' => $information));
        }
    }

    public function searchLocation()
    {
        if ($this->isLogin())
        {
            $key = $this->f3->get('POST.team');
            $data = array();
            $command = $this->getSearchCommand(array('city', 'country', 'address', 'company'), $key);
            $results = Model::get('location')->callGremlin($command);
            if ($results)
            {
                foreach ($results as $value)
                {
                    $location[$value] = Model::get('location')->callGremlin("current.map", array('@rid' => '#' . $value));
                    $data[] = array(
                        'id' => $value,
                        'label' => $location[$value][0]->city . ', ' . $location[$value][0]->country,
                        'value' => $location[$value][0]->city . ', ' . $location[$value][0]->country
                    );
                }
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($data);
        }
    }

    public function searchInfoUser()
    {
        if ($this->isLogin())
        {
            $act = $_GET['act'];
            $term = $_GET['term'];
            $data = array();
            $command = $this->getSearchCommand(array('university', 'concentrations', 'school'), $term);
            $results = Model::get('information')->callGremlin($command);
            if ($results)
            {
                foreach ($results as $value)
                {
                    $info[$value] = Model::get('location')->callGremlin("current.map", array('@rid' => '#' . $value));
                    switch ($act)
                    {
                        case 'university':
                            $name = $info[$value][0]->university;
                            break;
                        case 'concentrations':
                            $name = $info[$value][0]->concentrations;
                            break;
                        case 'school':
                            $name = $info[$value][0]->school;
                            break;
                    }
                    $data[] = array(
                        'id' => $value,
                        'lable' => $name,
                        'value' => $name
                    );
                }
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($data);
        }
    }

}
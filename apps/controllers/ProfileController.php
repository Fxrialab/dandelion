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
            $currentProfileID = $currentProfileRC->recordID;
            $information = $this->facade->findByAttributes('information', array('user' => $currentProfileID));
            $location = $this->facade->findByPk('location', $information->data->work_location);
            //get status friendship
            $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
            //set currentUser and otherUser for check in profile element and header
            $this->f3->set('currentUser', $this->getCurrentUser());
            $this->f3->set('otherUser', $this->getCurrentUser());
            $this->f3->set('statusFriendShip', $statusFriendShip);
            switch ($_GET['section'])
            {
                case 'overview':

                    $this->render('profile/overview.php', 'default', array('username' => $username, 'active' => 'overview', 'location' => $location));
                    break;
                case 'education':
                    $this->render('profile/education.php', 'default', array('username' => $username, 'active' => 'education', 'location' => $location, 'information' => $information));
                    break;
                case 'living':
                    $this->render('profile/living.php', 'default', array('username' => $username, 'active' => 'living', 'information' => $information));
                    break;
                case 'contact':
                    $this->render('profile/contact.php', 'default', array('username' => $username, 'active' => 'contact'));
                    break;
                case 'relationship':
                    $this->render('profile/relationship.php', 'default', array('username' => $username, 'active' => 'relationship'));
                    break;
                case 'bio':
                    $this->render('profile/bio.php', 'default', array('username' => $username, 'active' => 'bio'));
                    break;
                case 'year-overviews':
                    $this->render('profile/yearOverviews.php', 'default', array('username' => $username, 'active' => 'year-overviews'));
                    break;
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
            $location = $this->facade->findByPk('location', $information->data->work_location);
            $this->render('profile/editWork.php', 'default', array('location' => $location, 'information' => $information));
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
            $location = $this->facade->findByPk('location', $information->data->work_location);
            $this->render('profile/editCollege.php', 'default', array('location' => $location, 'information' => $information));
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
            $location = $this->facade->findByPk('location', $information->data->work_location);
            $this->render('profile/editSchool.php', 'default', array('location' => $location, 'information' => $information));
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
            $location = $this->facade->findByPk('location', $information->data->work_location);
            $this->render('profile/editCity.php', 'default', array('location' => $location, 'information' => $information, 'name' => 'current'));
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
            $location = $this->facade->findByPk('location', $information->data->work_location);
            $this->render('profile/editCity.php', 'default', array('location' => $location, 'information' => $information, 'name' => 'current'));
        }
    }

    public function searchLocation()
    {
        if ($this->isLogin())
        {
            $searchText = $this->f3->get("POST.q");
            $data = array();
            $command = $this->getSearchCommand(array('country'), $searchText);
            $result = Model::get('location')->callGremlin($command);
            if (!empty($result))
            {
                foreach ($result as $people)
                {
                    $location[$people] = Model::get('location')->callGremlin("current.map", array('@rid' => '#' . $people));
                    $data[] = array(
                        'id' => $people,
                        'name' => $location[$people][0]->city . ', ' . $location[$people][0]->country,
                    );
                }
            }
            echo json_encode($data);
        }
    }

}
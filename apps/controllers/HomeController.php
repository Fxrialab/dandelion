<?php
class HomeController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->layout = 'index';

        if ($this->isLogin())
            header("Location:/home");
        else
            $this->render('user/index.php', 'default');
    }

    public function home()
    {
        if ($this->isLogin())
        {
            $this->layout = 'home';

            //load js file of all modules existed
            $js = glob(MODULES . '*/webroot/js/*.js');
            $loadJS = array();
            foreach ($js as $jsFile)
            {
                $jsMod = substr($jsFile, strpos($jsFile, 'app'));
                array_push($loadJS, BASE_URL . $jsMod);
            }
            $this->f3->set('js', $loadJS);
            $this->f3->set('loggedUserID', $this->f3->get('SESSION.userID'));
            $this->render('home/home.php', 'default');
        }
        else
        {
            header("Location: /");
        }
    }

    public function loading()
    {
        if ($this->isLogin())
        {
            $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
            $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();
            $obj = new ObjectHandler();
            $obj->owner = $this->getCurrentUser()->recordID;
            $obj->type = 'post';
            $obj->select = 'LIMIT ' . $limit . ' ORDER BY published DESC offset ' . $offset;
            $activitiesRC = $this->facade->findAll('activity', $obj);
            $homes = array();
            if (!empty($activitiesRC))
            {
                foreach ($activitiesRC as $key => $activity)
                {
                    $verbMod = $activity->data->verb . 'Controller';
                    $obj = new $verbMod;
                    if (method_exists($obj, 'bindingData'))
                    {
                        $home = $obj->bindingData($activity, $key);
                        array_push($homes, $home);
                    }
                }
            }
            $this->render('home/view.php', 'default', array('activities' => $homes));
        }
    }

    public function listenPost()
    {
        if ($this->isLogin())
        {
            $objID = $this->f3->get('POST.data');
            $activity = $this->facade->findByPk('activity', $objID);
            if (!empty($activity))
            {
                $mod = $activity->data->type;
                $currentUser = $this->facade->findByPk('user', $activity->data->owner);
                if ($mod == 'post')
                {
                    $status = $this->facade->findByPk('status', $activity->data->object);
                }elseif ($mod == 'photo') {
                    //@TODO: check it later
                    $status = $this->facade->findByPk('photo', $activity->data->object);
                }
                $this->f3->set('status', $status);
                $this->f3->set('statusID', $status->recordID);
                $this->f3->set('content', $status->data->content);
                //$this->f3->set('tagged', 'none');
                $this->f3->set('currentUser', $currentUser);
                $this->f3->set('published', $status->data->published);
                $this->renderModule('postStatus', 'post');
            }
        }
    }

    public function notifications()
    {
        if ($this->isLogin())
        {
            $data = $this->f3->get('POST.data');
            if (!empty($data))
            {
                $this->f3->set('data', $data);
                $this->render('home/items.php', 'default');
            }
            //var_dump($data['type']);
        }
    }

    public function loadNotifications()
    {
        if ($this->isLogin())
        {
            $currentUserID = $this->f3->get('SESSION.userID');
            //update has read all notifications
            $isRead = array(
                'notifications' => 0,
            );
            $this->facade->updateByAttributes('notify', $isRead, array('userID'=>$currentUserID));
            //load all notifications
            $obj = new ObjectHandler();
            $obj->owner = $currentUserID;
            $obj->type  = 'notifications';
            $obj->select= "ORDER BY timers DESC";
            $notification = $this->facade->findAll('activity', $obj);
            $this->f3->set('notification', $notification);
            $this->f3->set('currentUserID', $currentUserID);
            $this->render('home/notifications.php', 'default');
        }
    }

    public function loadFriendRequests()
    {
        if ($this->isLogin())
        {
            $currentUserID = $this->f3->get('SESSION.userID');
            //update has read all notifications
            $isRead = array(
                'friendRequests' => 0,
            );
            $this->facade->updateByAttributes('notify', $isRead, array('userID'=>$currentUserID));
            //load all friend requests
            $obj = new ObjectHandler();
            $obj->owner = $currentUserID;
            $obj->type  = 'friendRequests';
            $obj->select= "ORDER BY timers DESC";
            $notification = $this->facade->findAll('activity', $obj);
            $this->f3->set('notification', $notification);
            $this->f3->set('currentUserID', $currentUserID);
            $this->render('home/friendRequests.php', 'default');
        }
    }

    public function pull()
    {
        if ($this->isLogin())
        {
            $listActionsForSuggest = $this->facade->findAllAttributes('actions', array("isSuggest" => "yes"));
            $actionIDArrays = array();
            $actionElement = array();
            if (!empty($listActionsForSuggest))
            {
                foreach ($listActionsForSuggest as $listAction)
                {
                    array_push($actionIDArrays, $listAction->recordID);
                }

                $randomKeys = $this->randomKeys($actionIDArrays, 'randomSuggestElement');
                foreach ($randomKeys as $key)
                {
                    $suggestAction[$actionIDArrays[$key]] = $this->facade->findAllAttributes('actions', array("isSuggest" => "yes", "@rid" => $actionIDArrays[$key]));
                    array_push($actionElement, $suggestAction[$actionIDArrays[$key]][0]->data->actionElement);
                }
                //check if suggest by friend request is null. Will not return to load element
                $this->f3->set('actionElement', $actionElement);
                $this->render('elements/loadedSuggestElement.php', 'default');
            }
        }
    }

    public function loadSuggest()
    {
        if ($this->isLogin())
        {
            $actionArrays = $this->f3->get('POST.actionsName');
            if (!empty($actionArrays))
            {
                foreach ($actionArrays as $action)
                {
                    $this->suggest($action);
                }
            }
        }
    }

    public function search()
    {
        if ($this->isLogin())
        {
            $searchText = $this->f3->get("POST.data");

            $data = array(
                'results' => array(),
                'success' => false,
                'error' => ''
            );
            $command = $this->getSearchCommand(array('firstName', 'lastName', 'fullName'), $searchText);
            $result = Model::get('user')->callGremlin($command);

            if (!empty($result))
            {
                foreach ($result as $people)
                {
                    $infoOfSearchFound[$people] = Model::get('user')->callGremlin("current.map", array('@rid' => '#' . $people));
                    if ($infoOfSearchFound[$people][0]->profilePic != 'none'){
                        $photo = HelperController::findPhoto($infoOfSearchFound[$people][0]->profilePic);
                        $avatar = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
                    }else {
                        $gender = HelperController::findGender($people);
                        if ($gender =='male')
                            $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                        else
                            $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
                    }
                    $data['results'][] = array(
                        'recordID' => str_replace(':', '_', $people),
                        'firstName' => ucfirst($infoOfSearchFound[$people][0]->firstName),
                        'lastName' => ucfirst($infoOfSearchFound[$people][0]->lastName),
                        'username' => $infoOfSearchFound[$people][0]->username,
                        'profilePic' => $avatar,
                    );
                }
                $data['success'] = true;
            }
            else
            {
                $data['error'] = "Your search did not return any results";
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode((object) $data);
        }
    }

    public function moreSearch()
    {
        if ($this->isLogin())
        {
            $this->layout = 'home';

            $searchText = $this->f3->get("GET.search");
            $command = $this->getSearchCommand(array('firstName', 'lastName', 'fullName'), $searchText);
            $resultSearch = Model::get('user')->callGremlin($command);
            if (!empty($resultSearch))
            {
                foreach ($resultSearch as $people)
                {
                    $infoOfSearchFound[$people] = Model::get('user')->callGremlin("current.map", array('@rid' => '#' . $people));
                }
                $this->f3->set('resultSearch', $resultSearch);
                $this->f3->set('infoOfSearchFound', $infoOfSearchFound);
                $this->render('home/searchResult.php', 'default');
            }
        }
    }

}

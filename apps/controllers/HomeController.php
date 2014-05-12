<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/31/13 - 2:18 PM
 * Project: UserWired Network - Version: beta
 */
class HomeController extends AppController
{

    protected $helpers = array();

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
            $this->f3->set('currentProfileID', $this->getCurrentUser()->recordID);
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
            if ($_POST['type'] == 'group')
            {
                $obj->type = $_POST['type'];
                $obj->typeID = $_POST['typeID'];
            }
            else
            {
                $obj->type = 'post';
            }

            $obj->select = 'LIMIT ' . $limit . ' ORDER BY published DESC offset ' . $offset;
            $activitiesRC = $this->facade->findAll('activity', $obj);
            //var_dump($activitiesRC);
            if (!empty($activitiesRC))
            {
                $homes = array();
                foreach ($activitiesRC as $key => $activity)
                {
                    $verbMod = $activity->data->verb;
                    $obj = new $verbMod;
                    if (method_exists($obj, 'viewPost'))
                    {
                        $home = $obj->viewPost($activity, $key);
                        array_push($homes, $home);
                        $this->f3->set('activities', $homes);
                    }
                }
            }
            $this->render('home/view.php', 'default');
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

                    $data['results'][] = array(
                        'recordID' => str_replace(':', '_', $people),
                        'firstName' => ucfirst($infoOfSearchFound[$people][0]->firstName),
                        'lastName' => ucfirst($infoOfSearchFound[$people][0]->lastName),
                        'username' => $infoOfSearchFound[$people][0]->username,
                        'profilePic' => $infoOfSearchFound[$people][0]->profilePic,
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
                $this->render('user/searchResult.php', 'default');
            }
        }
    }

}

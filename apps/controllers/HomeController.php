<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/31/13 - 2:18 PM
 * Project: UserWired Network - Version: beta
 */
class HomeController extends AppController {

    //protected $uses = array("Activity", "User", "Friendship", "Actions");
    protected $helpers = array();

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->layout = 'index';
        if ($this->isLogin())
            header("Location:/home");
        else
            $this->render('user/index.php', 'default');
    }

    public function home() {
        if ($this->isLogin()) {
            $this->layout = 'home';
            //load js file of all modules existed
            $js = glob(MODULES . '*/webroot/js/*.js');
            $loadJS = array();
            foreach ($js as $jsFile) {
                $jsMod = substr($jsFile, strpos($jsFile, 'app'));
                array_push($loadJS, BASE_URL . $jsMod);
            }
            $this->f3->set('js', $loadJS);
            $this->f3->set('currentProfileID', $this->getCurrentUser()->recordID);
            $this->render('home/home.php', 'default');
        } else {
            header("Location: /");
        }
    }
    public function morePostHome() {
        if ($this->isLogin()) {
            $published = $this->f3->get('POST.published');
            $activitiesRC = Model::get('activity')->findByCondition("owner = '" . $this->getCurrentUser()->recordID . "' and published < '" . $published . "'");
            $this->f3->set('currentUser', $this->getCurrentUser());
            if (!empty($activitiesRC)) {
                $homes = array();
                foreach ($activitiesRC as $key => $activity) {
                    $verbMod = $activity->data->verb;
                    $obj = new $verbMod;
                 
                    if (method_exists($obj, 'viewPost')) {
                        $home = $obj->viewPost($activity, $key);
                        array_push($homes, $home);
                        $this->f3->set('activities', $homes);
                    }
                }
                $this->render('home/moreHome.php', 'default');
            } else {
                $this->render('user/noMoreHome.php', 'default');
            }
        } else {
            header("Location: /");
        }
    }

    public function loading() {
        $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
        $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();
        $activitiesRC = Model::get('activity')->findByCondition("type = 'post' limit $limit ORDER BY published DESC offset $offset");
        if (!empty($activitiesRC)) {
            $homes = array();
            foreach ($activitiesRC as $key => $activity) {
                $verbMod = $activity->data->verb;
                $obj = new $verbMod;
                if (method_exists($obj, 'viewPost')) {
                    $home = $obj->viewPost($activity, $key);
                    array_push($homes, $home);
                    $this->f3->set('activities', $homes);
                }
            }
        }
        $this->render('home/view.php', 'default');
    }

    public function moreCommentHome() {
        if ($this->isLogin()) {
            $activityID = F3::get('POST.activity_id');
            $activitiesRC = $this->Activity->findByCondition("@rid = ? ", array($activityID));
            if ($activitiesRC) {
                $resultComments = array();
                foreach ($activitiesRC as $oneComment) {
                    $modulesType = substr($oneComment->data->verb, 0, strpos($oneComment->data->verb, $oneComment->data->object)) . 'controller';
                    foreach (glob(MODULES . '*/controllers/' . $modulesType . '.php') as $modulesFileControl) {
                        if (file_exists($modulesFileControl)) {
                            $modController = new $modulesType;
                            if (method_exists($modController, 'loadComment')) {
                                $resultComment = $modController->loadComment($oneComment->data->object, $oneComment->data->actor, $oneComment->recordID);
                                array_push($resultComments, $resultComment);
                            }
                        }
                    }
                }
                F3::set('commentAmq', $resultComments);
                $this->render('user/commentAMQ.php', 'default');
            }
        } else {
            header("Location: /");
        }
    }

    public function pull() {
        if ($this->isLogin()) {
            $listActionsForSuggest = Model::get('activity')->findByAttributes(array("isSuggest =>yes"));
            $actionIDArrays = array();
            $actionElement = array();
            if ($listActionsForSuggest) {
                foreach ($listActionsForSuggest as $listAction) {
                    array_push($actionIDArrays, $listAction->recordID);
                }

                $randomKeys = $this->randomKeys($actionIDArrays, 'randomSuggestElement');
                foreach ($randomKeys as $key) {
                    $suggestAction[$actionIDArrays[$key]] = Model::get('actions')->findByCondition("isSuggest = 'yes' AND @rid = '" . $actionIDArrays[$key] . "'");
                    array_push($actionElement, $suggestAction[$actionIDArrays[$key]][0]->data->actionElement);
                }
                //check if suggest by friend request is null. Will not return to load element
                $this->f3->set('actionElement', $actionElement);
                $this->render('elements/loadedSuggestElement.php', 'default');
            }
        }
    }

    public function loadSuggest() {
        if ($this->isLogin()) {
            $actionArrays = $this->f3->get('POST.actionsName');
            if ($actionArrays) {
                foreach ($actionArrays as $action) {
                    $this->suggest($action);
                }
            }
        }
    }

    public function search() {
        if ($this->isLogin()) {
            $searchText = $this->f3->get("POST.data");

            $data = array(
                'results' => array(),
                'success' => false,
                'error' => ''
            );
            $command = $this->getSearchCommand(array('firstName', 'lastName', 'fullName'), $searchText);
            $result = $this->User->searchByGremlin($command);
            if ($result) {
                foreach ($result as $people) {
                    $infoOfSearchFound[$people] = $this->User->sqlGremlin("current.map", "@rid = ?", array('#' . $people));
                    $data['results'][] = array(
                        'recordID' => str_replace(':', '_', $people),
                        'firstName' => ucfirst($infoOfSearchFound[$people][0]->firstName),
                        'lastName' => ucfirst($infoOfSearchFound[$people][0]->lastName),
                        'username' => $infoOfSearchFound[$people][0]->username,
                        'profilePic' => $infoOfSearchFound[$people][0]->profilePic,
                    );
                }
                $data['success'] = true;
            } else {
                $data['error'] = "Your search did not return any results";
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode((object) $data);
        }
    }

    public function moreSearch() {
        if ($this->isLogin()) {
            $this->layout = 'default';

            $searchText = F3::get("GET.search");
            $command = $this->getSearchCommand(array('firstName', 'lastName', 'fullName'), $searchText);
            $resultSearch = $this->User->searchByGremlin($command);
            if ($resultSearch) {
                foreach ($resultSearch as $people) {
                    $infoOfSearchFound[$people] = $this->User->sqlGremlin("current.map", "@rid = ?", array('#' . $people));
                }
                $this->f3->set('resultSearch', $resultSearch);
                $this->f3->set('infoOfSearchFound', $infoOfSearchFound);
            }
            $this->f3->set('currentUser', $this->getCurrentUser());
            $this->f3->set('otherUser', $this->getCurrentUser());
            $this->render('user/searchResult.php', 'default');
        }
    }

}

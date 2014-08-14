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
            $this->render('user/index');
    }

    public function home()
    {
        if ($this->isLogin())
        {
            $this->layout = 'home';
            $obj = new ObjectHandler();
            $obj->active = '1';
            $obj->verb = 'post';
            $obj->select = 'ORDER BY published DESC';
            $activity = $this->facade->findAll('activity', $obj);
            if (!empty($activity))
            {
                $limit = 20;
                if (!empty($_GET['page']))
                    $data = $this->pagePost($_GET['page'], $activity, $limit);
                else
                    $data = $this->pagePost(1, $activity, $limit);
            } else
            {
                $data = array();
            }

            $this->render('home/home', array('data' => $data));
        }
        else
        {
            header("Location: /");
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
                }
                elseif ($mod == 'photo')
                {
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
                $this->renderPartial('home/items', array('data' => $data));
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
            $this->facade->updateByAttributes('notify', $isRead, array('userID' => $currentUserID));
            //load all notifications
            $obj = new ObjectHandler();
            $obj->owner = $currentUserID;
            $obj->type = 'notifications';
            $obj->select = "ORDER BY timers DESC";
            $notification = $this->facade->findAll('activity', $obj);
            $this->renderPartial('home/friendRequests', array('notification' => $notification, 'currentUserID' => $currentUserID));
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
            $this->facade->updateByAttributes('notify', $isRead, array('userID' => $currentUserID));
            //load all friend requests
            $obj = new ObjectHandler();
            $obj->owner = $currentUserID;
            $obj->type = 'friendRequests';
            $obj->select = "ORDER BY timers DESC";
            $notification = $this->facade->findAll('activity', $obj);
            $this->renderPartial('home/friendRequests', array('notification' => $notification, 'currentUserID' => $currentUserID));
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
                $this->renderPartial('elements/loadedSuggestElement', array('actionElement' => $actionElement));
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
                    if ($infoOfSearchFound[$people][0]->profilePic != 'none')
                        $avatar = $infoOfSearchFound[$people][0]->profilePic;
                    else
                        $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
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
                $this->render('searchResult', array('resultSearch' => $resultSearch, 'infoOfSearchFound' => $infoOfSearchFound));
            }
        }
    }

}

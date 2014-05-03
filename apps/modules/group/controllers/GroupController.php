<?php

/**
 * Author: Hoc Nguyen
 * Date: 12/21/12
 */
class GroupController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function groupSuccess()
    {
        $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
        $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();
        $obj = new ObjectHandler();
        $obj->privacy = 1;
        $obj->select = 'LIMIT ' . $limit . ' ORDER BY published DESC offset ' . $offset;
        $group = $this->facade->findAll('group', $obj);
        $this->f3->set('group', $group);
        $this->renderModule('view', 'Group');
    }

    public function removeGroup()
    {
        if (!empty($_POST['groupID']))
        {
            $this->facade->deleteByAttributes('groupMember', array('member' => $_POST['userID'], 'groupID' => $_POST['groupID']));
        }
        elseif (!empty($_POST['id']))
        {
            $user = $this->facade->findByPk('user', $_POST['id']);
            echo json_encode(array('userID' => $_POST['id'], 'name' => $user->data->fullName));
        }
    }

    public function addGroup($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $obj = new ObjectHandler();
            $this->render($viewPath . 'addGroup.php', 'modules');
        }
    }

    static public function findGroup($id)
    {
        return Model::get('group')->find(str_replace("_", ":", $id));
    }

    static public function findUser($id)
    {
        return Model::get('user')->find($id);
    }

    public function group($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $userID = $this->f3->get('SESSION.userID');
            $model = $this->facade->findAllAttributes('groupMember', array('member' => $userID));
            if (!empty($model))
                $this->f3->set('groupMember', $model);
            else
                $this->f3->set('groupMember', 'null');
            $this->render($viewPath . 'index.php', 'modules');
        }
    }

    public function successGroup()
    {
        if ($this->isLogin())
        {
            $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
            $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();
            $obj = new ObjectHandler();
            $obj->member = $this->f3->get('SESSION.userID');
            $obj->select = 'LIMIT ' . $limit . ' ORDER BY published DESC offset ' . $offset;
            $model = $this->facade->findAll('groupMember', $obj);
            if (!empty($model))
                $this->f3->set('groupMember', $model);
            else
                $this->f3->set('groupMember', 'null');
            $this->renderModule('groupmember', 'Group');
        }
    }

    public function joinGroup()
    {
        if ($this->isLogin())
        {
            $arrayUser = array(
                'groupID' => str_replace("_", ":", $_POST['id']),
                'member' => $this->f3->get('SESSION.userID'),
                'action' => '0',
                'published' => time(),
            );
            $groupUser = $this->facade->save('groupMember', $arrayUser);
            if (!empty($groupUser))
                echo '1';
            else
                echo '0';
//            $this->renderModule('joinGroup', 'group');
        }
    }

    public function members($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $groupID = str_replace("_", ":", $this->f3->get('GET.id'));
            if (!empty($_GET['act']))
            {
                if ($_GET['act'] = 'admin')
                {
                    $members = $this->facade->findAllAttributes('groupMember', array('groupID' => $groupID, 'admin' => 'admin'));
                    $this->f3->set('admin', 'admin');
                }
            }
            else
            {
                $members = $this->facade->findAllAttributes('groupMember', array('groupID' => $groupID));
                $this->f3->set('admin', 'member');
            }

            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $count = $this->facade->count('groupMember', array('groupID' => $groupID));
            $this->f3->set('group', $group);
            $this->f3->set('members', $members);
            $this->f3->set('countMember', $count);
            $this->render($viewPath . 'members.php', 'modules');
        }
    }

    public function editDescription()
    {
        if (!empty($_POST['id']))
        {
            $this->f3->set('groupID', $_POST['id']);
            $group = $this->facade->findByPk('group', str_replace("_", ":", $_POST['id']));
            $this->f3->set('group', $group);
            $this->renderModule('formDescription', 'Group');
        }
        elseif (!empty($_POST['groupDescription']))
        {
            $updateGroup = array(
                'description' => $_POST['groupDescription']
            );
            $this->facade->updateByAttributes('group', $updateGroup, array('@rid' => '#' . str_replace("_", ":", $_POST['groupID'])));
            echo json_encode(array('groupID' => $_POST['groupID'], 'description' => $_POST['groupDescription']));
        }
    }

    public function makeAdmin()
    {
        if (!empty($_POST['id']))
        {
            $user = $this->facade->findByPk('user', $_POST['id']);
            echo json_encode(array('userID' => $_POST['id'], 'name' => $user->data->fullName));
        }
        elseif (!empty($_POST['groupID']))
        {
            $updateGroup = array(
                'admin' => 'admin'
            );
            $admin = $this->facade->updateByAttributes('groupMember', $updateGroup, array('member' => $_POST['userID'], 'groupID' => $_POST['groupID']));
            if ($admin == 1)
                echo '1';
            else
                echo '0';
        }
    }

    public function groupDetail($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $groupID = $this->f3->get('GET.id');
            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $this->f3->set('group', $group);
            $this->render($viewPath . 'detail.php', 'modules');
        }
    }

    public function addmember()
    {
        if ($this->isLogin())
        {
            $searchText = $this->f3->get("POST.q");
            $groupID = $this->f3->get("POST.groupID");
            $data = array();
            $command = $this->getSearchCommand(array('fullName'), $searchText);

            $result = Model::get('user')->callGremlin($command);
            if (!empty($result))
            {
                foreach ($result as $people)
                {
                    $infoOfSearchFound[$people] = Model::get('user')->callGremlin("current.map", array('@rid' => '#' . $people));
                    if (!empty($_POST['groupID']))
                    {
                        $member = $this->facade->findAllAttributes('groupMember', array('member' => $people, 'groupID' => str_replace("_", ":", $groupID)));
                        if (!empty($member))
                            $mess = 'Đã tham gia';
                        else
                            $mess = '';
                    }
                    else
                    {
                        $mess = '';
                    }
                    $data[] = array(
                        'id' => $people,
                        'name' => $infoOfSearchFound[$people][0]->fullName,
                        'avatar' => $infoOfSearchFound[$people][0]->profilePic,
                        'mess' => $mess,
                    );
                }
            }
            echo json_encode($data);
        }
    }

    public function addMemberGroup()
    {
        if ($this->isLogin())
        {
            $actor = explode(',', $_POST['groupAddMember']);
            $data = array();
            foreach ($actor as $value)
            {
                $member = $this->facade->findAllAttributes('groupMember', array('member' => $value, 'groupID' => $_POST['groupID']));
                $user = Model::get('user')->find($value);
                if (!empty($member))
                {
                    $mess = TRUE;
                }
                else
                {
                    $arrayMember = array(
                        'groupID' => $_POST['groupID'],
                        'member' => $value,
                        'action' => '1',
                        'published' => time(),
                    );
                    $groupMember = $this->facade->save('groupMember', $arrayMember);
                    $mess = FALSE;
                }
                $data[] = array(
                    'id' => $value,
                    'name' => $user->data->fullName,
                    'mess' => $mess,
                );
            }
            $json = json_encode($data);
            $obj = json_decode($json);
            $this->f3->set('members', $obj);
            $this->renderModule('viewMember', 'Group');
        }
    }

    public function create()
    {
        if ($this->isLogin() && !empty($_POST['groupName']))
        {
            $actor = explode(',', $_POST['groupMember']);
            $array = array(
                'name' => $_POST['groupName'],
                'owner' => $this->f3->get('SESSION.userID'),
                'numMember' => count($actor),
                'privacy' => $_POST['groupPrivacy'],
                'published' => time(),
            );
            $group = $this->facade->save('group', $array);
            if (!empty($group))
            {
                $arrayUser = array(
                    'groupID' => $group,
                    'member' => $this->f3->get('SESSION.userID'),
                    'action' => '0',
                    'published' => time(),
                    'admin' => 'admin',
                );
                $groupUser = $this->facade->save('groupMember', $arrayUser);
                if (!empty($actor))
                {
                    foreach ($actor as $key => $value)
                    {
                        $arrayMember = array(
                            'groupID' => $group,
                            'member' => $value,
                            'action' => '1',
                            'published' => time(),
                            'admin' => 'member',
                        );
                        $groupMember = $this->facade->save('groupMember', $arrayMember);
                    }
                }
                $model = Model::get('group')->find($group);
                $this->f3->set('group', $model);
                $this->f3->set('name', $_POST['groupName']);
            }
            $this->renderModule('viewGroup', 'Group');
        }
    }

    public function detail($viewPath)
    {
        if ($this->isLogin())
        {
            $groupID = $this->f3->get('GET.id');
            $this->layout = 'group';
            $group = Model::get('group')->findByPk($groupID);
            $this->f3->set('group', $group);
            $this->render($viewPath . 'detail.php', 'modules');
        }
    }

}

?>

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
            if ($_GET['category'] = 'membership')
            {
                $model = $this->facade->findAllAttributes('groupMember', array('member' => $userID));
            }
            elseif ($_GET['category'] = 'admin')
            {
                $model = $this->facade->findAllAttributes('groupMember', array('member' => $userID, 'admin' => 'admin'));
            }
            else if ($_GET['category'] = 'nearby')
            {
                $obj = new ObjectHandler();
                $obj->member = $userID;
                $obj->select = 'LIMIT 10 ORDER BY published DESC';
                $model = $this->facade->findAll('groupMember', $obj);
            }
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
            $obj->select = 'and published > 1399543903 LIMIT ' . $limit . ' ORDER BY published DESC offset ' . $offset;
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
            if ($_GET['act'] == 'admin')
            {
                $members = $this->facade->findAllAttributes('groupMember', array('groupID' => $groupID, 'role' => 'admin'));

                $this->f3->set('admin', 'admin');
            }
            else
            {
                $members = $this->facade->findAllAttributes('groupMember', array('groupID' => $groupID));

                $this->f3->set('admin', 'membership');
            }

            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $countAdmin = $this->facade->count('groupMember', array('groupID' => $groupID, 'role' => 'admin'));
            $count = $this->facade->count('groupMember', array('groupID' => $groupID));
            $this->f3->set('group', $group);
            $this->f3->set('members', $members);
            $this->f3->set('countMember', $count);
            $this->f3->set('countAdmin', $countAdmin);
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

    public function myphotos()
    {
        $photos = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
        $this->f3->set('photos', $photos);
        $this->f3->set('groupID', $_POST['id']);
        $this->renderModule('myphotos', 'Group');
    }

    public function leave()
    {
        if (!empty($_POST['action']))
        {
            $delete = $this->facade->deleteByAttributes('groupMember', array('groupID' => str_replace("_", ":", $_POST['groupID']), 'member' => $this->f3->get('SESSION.userID')));
            echo json_encode(array('del' => $delete, 'groupID' => $_POST['groupID']));
        }
        else
        {
            $this->f3->set('groupID', $_POST['groupID']);
            $this->renderModule('leave', 'Group');
        }
    }

    public function cover()
    {
        if (!empty($_POST['photoID']))
        {
            $photo = $this->facade->findByPk('photo', str_replace("_", ":", $_POST['photoID']));
            $updateGroup = array(
                'urlCover' => $photo->data->url,
            );
            $group = $this->facade->updateByAttributes('group', $updateGroup, array('@rid' => '#' . $_POST['groupID']));
            if ($group == 1)
            {
                $this->f3->set('url', $photo->data->url);
                $this->f3->set('photoID', $photoID);
            }
            $this->f3->set('groupID', $_POST['groupID']);

            $this->renderModule('cover', 'Group');
        }
    }

    public function groupDetail($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $groupID = $this->f3->get('GET.id');
            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $member = $this->facade->findAllAttributes('groupMember', array('groupID' => str_replace("_", ":", $groupID)));
            $photo = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
            $this->f3->set('photo', $photo);
            $this->f3->set('group', $group);
            $this->f3->set('member', $member);
            $this->render($viewPath . 'detail.php', 'modules');
        }
    }

    public function create()
    {
        if ($this->isLogin())
        {
            if (!empty($_POST['groupName']))
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
                    if (!empty($actor))
                    {
                        foreach ($actor as $key => $value)
                        {
                            if ($value == $this->f3->get('SESSION.userID'))
                            {
                                $action = 0;
                                $admin = 'admin';
                            }
                            else
                            {
                                $action = 1;
                                $admin = 'member';
                            }
                            $arrayMember = array(
                                'groupID' => $group,
                                'member' => $value,
                                'action' => $action,
                                'published' => time(),
                                'role' => $admin,
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
            else
            {
                $this->renderModule('form', 'Group');
            }
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

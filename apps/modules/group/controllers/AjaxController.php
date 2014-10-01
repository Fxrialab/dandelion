<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxController extends AppController
{

    public function addFriend()
    {
        if (!empty($_POST['groupID']))
        {
            $this->f3->set('groupID', $_POST['groupID']);
            $this->renderModule('addFriend', 'group');
        }
    }

    public function searchFriends()
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
            $actor = explode(',', $_POST['groupAddFriend']);
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
                        'groupID' => $_POST['groupID'],
                        'member' => $value,
                        'action' => $action,
                        'role' => $admin,
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
            $this->renderModule('viewMember', 'group');
        }
    }

    public function removeGroup()
    {
        if (!empty($_POST['userID']) && !empty($_POST['groupID']))
        {
            $user = $this->facade->findByPk('user', $_POST['userID']);
            $group = $this->facade->findByPk('group', $_POST['groupID']);
            $this->f3->set('user', $user);
            $this->f3->set('group', $group);
            $this->renderModule('removeGroup', 'group');
        }
    }

    public function comfirmRemoveGroup()
    {
        if (!empty($_POST['userID']) && !empty($_POST['groupID']))
        {
            $delete = $this->facade->deleteByAttributes('groupMember', array('member' => $_POST['userID'], 'groupID' => $_POST['groupID']));
            if ($delete == 1)
            {
                $group = $this->facade->findByPk('group', $_POST['groupID']);
                $user = $this->facade->findByPk('user', $_POST['userID']);
                echo json_encode(array('groupID' => str_replace(":", "_", $group->recordID), 'userID' => str_replace(":", "_", $user->recordID)));
            }
        }
    }

    public function rolegroup()
    {
        if (!empty($_POST['userID']) && !empty($_POST['groupID']))
        {
            $make = $this->facade->findByAttributes("groupMember", array('member' => $_POST['userID'], 'groupID' => $_POST['groupID']));

            $user = $this->facade->findByPk('user', $_POST['userID']);
            $group = $this->facade->findByPk('group', $_POST['groupID']);
            $this->f3->set('user', $user);
            $this->f3->set('group', $group);
            if ($user->recordID == $this->f3->get('SESSION.userID'))
                $name = 'yourself';
            else
                $name = $user->data->fullName;
            if ($make->data->role == 'admin')
            {
                $button = 'Remove Admin';
                $this->f3->set('message', 'You are about to remove ' . $name . ' as a group admin.');
            }
            else
            {
                $button = 'Make Admin';
                $this->f3->set('message', 'As a group admin, ' . $name . ' will be able to edit group settings, remove members and give other members admin status.');
            }

            $this->f3->set('button', $button);
            $this->renderModule('rolegroup', 'group');
        }
    }

    public function comfirmrole()
    {
        if (!empty($_POST['userID']) && !empty($_POST['groupID']))
        {
            $make = $this->facade->findByAttributes("groupMember", array('member' => $_POST['userID'], 'groupID' => $_POST['groupID']));
            if ($make->data->role == 'admin')
                $updateGroup = array('role' => 'member');
            else
                $updateGroup = array('role' => 'admin');
            $admin = $this->facade->updateByAttributes('groupMember', $updateGroup, array('member' => $_POST['userID'], 'groupID' => $_POST['groupID']));
            if (!empty($admin))
                echo json_encode(array('groupID' => str_replace(":", "_", $_POST['groupID'])));
        }
    }

    public function removeAdmin()
    {
        if (!empty($_POST['userID']) && !empty($_POST['groupID']))
        {
            $user = $this->facade->findByPk('user', $_POST['userID']);
            $group = $this->facade->findByPk('group', $_POST['groupID']);
            $this->f3->set('user', $user);
            $this->f3->set('group', $group);
            if ($user->recordID == $this->f3->get('SESSION.userID'))
                $name = 'yourself';
            else
                $name = $user->data->fullName;
            $this->f3->set('message', 'You are about to remove ' . $name . ' as a group admin.');
            $this->f3->set('button', 'Remove Admin');
            $this->renderModule('makeAdmin', 'group');
        }
    }

}

?>

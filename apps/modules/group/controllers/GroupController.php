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
            $this->render($viewPath . 'mains/addGroup.php', 'modules');
        }
    }

    public function group($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            if ($_GET['category'] == 'admin')
                $role = 'admin';
            else
                $role = 'all';
//            $userID = $this->f3->get('SESSION.userID');
//            $obj = new ObjectHandler();
//            $obj->member = $userID;
//
//            if ($_GET['category'] == 'admin')
//                $obj->role = 'admin';
//
//            $obj->select = 'LIMIT 5 ORDER BY published DESC';
//            $model = $this->facade->findAll('groupMember', $obj);
//            if (!empty($model))
//                $this->f3->set('groupMember', $model);
//            else
//                $this->f3->set('groupMember', 'null');
            $this->f3->set('role', $role);
            $this->render($viewPath . 'mains/index.php', 'modules');
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
            if ($_POST['roleGroup'] == 'admin')
                $obj->role = 'admin';
            $obj->select = 'and published > 1399543903 LIMIT ' . $limit . ' ORDER BY published DESC offset ' . $offset;
            $model = $this->facade->findAll('groupMember', $obj);
            if (!empty($model))
                $this->f3->set('groupMember', $model);
            else
                $this->f3->set('groupMember', 'null');
            $this->renderModule('mains/loadData', 'group');
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
            if (!empty($_POST['search']))
            {
                $searchText = $this->f3->get("POST.search");
                $act = $this->f3->get("GET.act");
                $data = array();
                $command = $this->getSearchCommand(array('fullName'), $searchText);
                $result = Model::get('user')->callGremlin($command);
                if (!empty($result))
                {
                    foreach ($result as $people)
                    {
                        if ($act == 'admin')
                        {
                            $member = $this->facade->findByAttributes('groupMember', array('member' => $people, 'groupID' => str_replace("_", ":", $groupID), 'role' => 'admin'));
                            $this->f3->set('admin', 'admin');
                        }
                        else
                        {
                            $member = $this->facade->findByAttributes('groupMember', array('member' => $people, 'groupID' => str_replace("_", ":", $groupID)));
                            $this->f3->set('admin', 'membership');
                        }
                        $data[] = array(
                            'recordID' => $member->recordID,
                            'groupID' => $member->data->groupID,
                            'member' => $member->data->member,
                            'action' => $member->data->action,
                            'published' => $member->data->published,
                            'role' => $member->data->role,
                        );
                    }
                }
                $json = json_encode($data);
                $members = json_decode($json);
            }
            else
            {
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
            }
            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $countAdmin = $this->facade->count('groupMember', array('groupID' => $groupID, 'role' => 'admin'));
            $count = $this->facade->count('groupMember', array('groupID' => $groupID));
            $this->f3->set('group', $group);
            $this->f3->set('members', $members);
            $this->f3->set('countMember', $count);
            $this->f3->set('countAdmin', $countAdmin);
            $this->render($viewPath . 'mains/members.php', 'modules');
        }
    }

    public function editDescription()
    {
        if (!empty($_POST['id']))
        {
            $this->f3->set('groupID', $_POST['id']);
            $group = $this->facade->findByPk('group', str_replace("_", ":", $_POST['id']));
            $this->f3->set('group', $group);
            $this->renderModule('mains/formDescription', 'group');
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
            $this->renderModule('mains/leave', 'group');
        }
    }

    public function groupdetail($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $groupID = $this->f3->get('GET.id');
            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $member = $this->facade->findAllAttributes('groupMember', array('groupID' => str_replace("_", ":", $groupID)));
            $photo = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
            $count = $this->facade->count('groupMember', array('groupID' => $groupID));
            $this->f3->set('photo', $photo);
            $this->f3->set('group', $group);
            $this->f3->set('member', $member);
            $this->f3->set('countMember', $count);
            $this->render($viewPath . 'mains/detail.php', 'modules');
        }
    }

    public function photoBrowsers()
    {
        if ($this->isLogin())
        {
            $photos = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
            $this->f3->set('photos', $photos);
            $this->f3->set('groupID', $_POST['id']);
            $this->renderModule('photoGalleries', 'group');
        }
    }

    public function choosePhoto()
    {
        if ($this->isLogin())
        {
            $photoID = $_POST['photoID'];
            $photo = $this->facade->findByPk('photo', $photoID);
            $image = array('name' => $photo->data->fileName, 'width' => $photo->data->width, 'height' => $photo->data->height);
            $this->f3->set('image', $image);
            $this->f3->set('target', 'choosePhoto');
            $this->renderModule('cover', 'group');
        }
    }

    public function uploadphoto()
    {
        if ($this->isLogin())
        {
            $coverDir = UPLOAD . "cover/750px";
            $thumbnailDir = UPLOAD . "thumbnails/150px"; //The folder will display like gallery images on "Choose from my photos"

            if (isset($_FILES["myfile"]))
            {
                if (!is_array($_FILES["myfile"]['name'])) //single file
                {
                    $file = $_FILES["myfile"];
                    $newName = time();
                    $this->changeImage($file, 150, $thumbnailDir, $newName, 80, false);
                    $image = $this->changeImage($file, 750, $coverDir, $newName, 100, true);
                    $this->f3->set('image', $image);
                    $this->f3->set('target', 'uploadCover');
                    $this->renderModule('cover', 'group');
                }
            }
        }
    }

    public function saveCover()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $target = $_POST['target'];
            $file = $_POST['coverFile'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            $dragX = $_POST['dragX'];
            $dragY = $_POST['dragY'];
            $groupID = $_POST['groupID'];
            switch ($target)
            {
                case 'uploadCover':
                    $entry = array(
                        'actor' => $currentUser->recordID,
                        'album' => '',
                        'fileName' => $file,
                        'width' => $width,
                        'height' => $height,
                        'dragX' => $dragX,
                        'dragY' => $dragY,
                        'thumbnail_url' => '',
                        'description' => '',
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => time(),
                        'type' => 'cover'
                    );
                    $photoID = $this->facade->save('photo', $entry);
                    $updateGroup = array(
                        'coverGroup' => $photoID,
                    );
                    break;
                case 'choosePhoto':
                    $photo = $this->facade->findByAttributes('photo', array('fileName' => $file));
                    $photoID = $photo->recordID;
                    $entry = array(
                        'dragX' => $dragX,
                        'dragY' => $dragY
                    );
                    $this->facade->updateByAttributes('photo', $entry, array('@rid' => '#' . $photoID));
                    $updateGroup = array(
                        'coverGroup' => $photoID,
                    );
                    break;
                case 'isReposition':
                    $photoID = $file;
                    $entry = array(
                        'dragX' => $dragX,
                        'dragY' => $dragY,
                        'type' => 'cover'
                    );
                    $this->facade->updateByAttributes('photo', $entry, array('@rid' => '#' . $photoID));
                    $updateGroup = array(
                        'coverGroup' => $photoID,
                    );
                    break;
            }
            $this->facade->updateByAttributes('group', $updateGroup, array('@rid' => '#' . $groupID));
        }
    }

    public function cancelCover()
    {
        if ($this->isLogin())
        {
            $groupID = $_POST['groupID'];
            $target = $_POST['target'];
            $group = $this->facade->findByPk('group', $groupID);
            if (!empty($target))
            {
                if ($target == 'coverGroup')
                {
                    if ($group->data->coverGroup != 'none')
                    {
                        $photo = $this->facade->findByPk('photo', $group->data->coverGroup);
                        echo json_encode(array(
                            'src' => UPLOAD_URL . "cover/750px/" . $photo->data->fileName,
                            'width' => $photo->data->width,
                            'height' => $photo->data->height,
                            'left' => $photo->data->dragX,
                            'top' => $photo->data->dragY,
                            'photoID' => $photo->recordID,
                        ));
                    }
                    else
                    {
                        echo json_encode(array(
                            'src' => false
                        ));
                    }
                }
            }
        }
    }

    public function reposition()
    {
        if ($this->isLogin())
        {
            $photoID = $_POST['id'];
            $photo = $this->facade->findByPk('photo', $photoID);
            $this->f3->set('photo', $photo);
            $this->renderModule('reposition', 'group');
        }
    }

    public function remove()
    {
        if (!empty($_POST['groupID']))
        {
            $groupID = $_POST['groupID'];
            $updateGroup = array(
                'coverGroup' => 'none',
            );
            $this->facade->updateByAttributes('group', $updateGroup, array('@rid' => '#' . $groupID));
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
                    'coverGroup' => 'none',
                    'published' => time()
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
                }
                $this->renderModule('mains/viewGroup', 'group');
            }
            else
            {
                $this->renderModule('mains/form', 'group');
            }
        }
    }

}

?>

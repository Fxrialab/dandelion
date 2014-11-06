<?php

class GroupController extends AppController
{

    protected $helpers = array("String");

    public function __construct()
    {
        parent::__construct();
    }

    public function addGroup()
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $this->renderModule("addGroup", 'photo');
        }
    }

    public function group()
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
            $this->renderModule('index', 'group', array('role' => $role));
        }
    }

    /**
     *  This is loading all activity on group module
     */
    public function dataPost($entry, $key)
    {
        if (!empty($entry))
        {
            $currentUser = $this->getCurrentUser();
            if (!empty($entry->data->object))
                $id = $entry->data->object;
            else
                $id = $entry->recordID;
            $statusRC = $this->facade->findByAttributes('status', array('@rid' => '#' . $id, 'active' => 1));

            if (!empty($statusRC))
            {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $this->facade->findByPk("user", $statusRC->data->owner);

                $like = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $statusID));
                $photo = $this->facade->findAllAttributes('photo', array('typeID' => $statusRC->recordID));
                $comment = $this->facade->findAllAttributes('comment', array('typeID' => $statusRC->recordID));
                $commentArray = array();
                if (!empty($comment))
                {
                    foreach ($comment as $value)
                    {
                        $userComment = $this->facade->findByPk("user", $value->data->owner);
                        $likeComment = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $value->recordID));
                        $commentArray[] = array('comment' => $value, 'user' => $userComment, 'like' => $likeComment);
                    }
                }
                $entry = array(
                    'type' => 'post',
                    'key' => $key,
                    'like' => $like,
                    'user' => $userRC,
                    'photo' => $photo,
                    'comment' => $commentArray,
                    'actions' => $statusRC,
                );
                return $entry;
            }
        }
    }

    public function loading()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $groupID = $this->f3->get('POST.groupID');

            if (!empty($groupID))
            {
                $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
                $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();

                $obj = new ObjectHandler();
                $obj->typeID = $groupID;
                $obj->type = 'group';
                $obj->active = 1;
                $obj->select = "ORDER BY published DESC offset " . $offset . " LIMIT " . $limit;
                $statusRC = $this->facade->findAll('status', $obj);
                $data = array();
                if (!empty($statusRC))
                    foreach ($statusRC as $key => $status)
                    {
                        $statusRC = $this->facade->findByAttributes('status', array('@rid' => '#' . $status->recordID, 'active' => 1));

                        if (!empty($statusRC))
                        {
                            $statusID = $statusRC->recordID;
                            if ($currentUser->recordID != $statusRC->data->actor)
                                $userRC = $this->facade->findByPk("user", $statusRC->data->actor);
                            else
                                $userRC = $this->facade->findByPk("user", $statusRC->data->owner);

                            $like = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $statusID));
                            $photo = $this->facade->findAllAttributes('photo', array('typeID' => $statusRC->recordID));
                            $comment = $this->facade->findAllAttributes('comment', array('typeID' => $statusRC->recordID));
                            $commentArray = array();
                            if (!empty($comment))
                            {
                                foreach ($comment as $value)
                                {
                                    $userComment = $this->facade->findByPk("user", $value->data->owner);
                                    $likeComment = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $value->recordID));
                                    $commentArray[] = array('comment' => $value, 'user' => $userComment, 'like' => $likeComment);
                                }
                            }
                            $data[] = array(
                                'type' => 'post',
                                'key' => $key,
                                'like' => $like,
                                'user' => $userRC,
                                'photo' => $photo,
                                'comment' => $commentArray,
                                'actions' => $statusRC,
                            );
                        }
                    }

                $this->renderModule('post', 'group', array('data' => $data, 'page' => 'group'));
            }
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
            $groupArray = array();
            if (!empty($model))
            {

                foreach ($model as $value)
                {
                    $group = $this->facade->findByPk('group', $value->data->groupID);
                    $groupArray[] = array('group' => $group);
                }
            }

            $this->renderModule('loadData', 'group', array('group' => $groupArray));
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

    public function members()
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
                $command = $this->getSearchCommand(array('fullName', 'username'), $searchText);
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
                $memberArray = json_decode($json);
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
                $memberArray = array();
                foreach ($members as $value)
                {
                    $user = $this->facade->findByPk('user', $value->data->member);
                    $avatar = $this->facade->findByPk("photo", $user->recordID);
                    if (!empty($avatar))
                        $photoAvatar = $avatar->data->fileName;
                    else
                        $photoAvatar = 'avatarMenDefault.png';
                    $memberArray[] = array('member' => $value, 'user' => $user, 'avatar' => $avatar);
                }
            }
            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $countAdmin = $this->facade->count('groupMember', array('groupID' => $groupID, 'role' => 'admin'));
            $count = $this->facade->count('groupMember', array('groupID' => $groupID));
            $this->renderModule('members', 'group', array('group' => $group, 'members' => $memberArray, 'countMember' => $count, 'countAdmin' => $countAdmin));
        }
    }

    public function editDescription()
    {
        if (!empty($_POST['id']))
        {
            $this->f3->set('groupID', $_POST['id']);
            $group = $this->facade->findByPk('group', str_replace("_", ":", $_POST['id']));
            $this->f3->set('group', $group);
            $this->renderModule('formDescription', 'group');
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
            $this->f3->set('groupID', $_GET['id']);
            $this->renderModule('leave', 'group');
        }
    }

    public function groupdetail()
    {
        if ($this->isLogin())
        {
            $this->layout = 'group';
            $groupID = $this->f3->get('GET.id');
            $group = $this->facade->findByPk('group', str_replace("_", ":", $groupID));
            $member = $this->facade->findByAttributes('groupMember', array('groupID' => str_replace("_", ":", $groupID)));
            $photo = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
            $count = $this->facade->count('groupMember', array('groupID' => $groupID));
            $profile = $this->facade->findByAttributes("information", array('user' => $member->data->member));
            $this->f3->set('photo', $photo);
            $this->f3->set('group', $group);
            $this->f3->set('member', $member);
            $this->f3->set('countMember', $count);
            $this->renderModule('detail', 'group', array('group' => $group, 'member' => $member, 'photo' => $photo, 'countMember' => $count, 'avatar' => $profile->data->avatar));
        }
    }

    public function photoBrowsers()
    {
        if ($this->isLogin())
        {
            $photos = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
            $this->f3->set('photos', $photos);
            $this->f3->set('groupID', $_GET['id']);
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

    public function uploadCover()
    {
        if ($this->isLogin())
        {
            $tempDir = UPLOAD . "tmp/";
            $coverDir = UPLOAD . "cover/750px";
            if (isset($_FILES["myfile"]))
            {
//                if (!is_array($_FILES["myfile"]['name'])) //single file
//                {
                $file = $_FILES["myfile"];
                $code = $this->StringHelper->generateRandomString(5);
                $newName = $code . time();
                $image = $this->changeImage($file, 750, $coverDir, $newName, 100, true, $tempDir);
//                    var_dump($image);
                $this->renderModule('cover', 'group', array('image' => $image, 'target' => 'uploadCover'));
//                }
            }
        }
    }

    public function saveCover()
    {
        if ($this->isLogin())
        {
            $thumbnailDir = UPLOAD . "thumbnails/150px/"; //The folder will display like gallery images on "Choose from my photos"
            $imagesDir = UPLOAD . "images/";

            $currentUser = $this->getCurrentUser();
            $target = $_POST['target'];
            $file = $_POST['coverFile'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            $dragX = $_POST['dragX'];
            $dragY = $_POST['dragY'];
            $groupID = $_POST['groupID'];
            $pathFile = UPLOAD . 'tmp/' . $file;
            switch ($target)
            {
                case 'uploadCover':
                    //resize image to thumbnail, cover folder and move image from tmp folder to images folder
                    $this->resizeImageFile($pathFile, 150, $thumbnailDir . $file, 80);
                    rename($pathFile, $imagesDir . $file);
                    //prepare data for save
                    $entry = array(
                        'owner' => $currentUser->recordID,
                        'albumID' => '',
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
                    $model = $this->facade->findByPk('group', $group);
                    $this->f3->set('group', $model);
                }
                $this->renderModule('viewGroup', 'group');
            }
            else
            {
                $this->renderModule('form', 'group');
            }
        }
    }

}

?>

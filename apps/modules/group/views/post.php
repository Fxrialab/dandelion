<?php
$data = $this->f3->get('data');
if (!empty($data))
{
    foreach ($data as $mod)
    {
        foreach (glob(MODULES  . 'post/views/viewMod.php') as $views)
        {
            $photo = $mod["photo"];
            $status = $mod["actions"];
            $userID = $mod['user']->recordID;
            $username = $mod['user']->data->username;
            $like = $mod['like'];
            $actorName = $mod['user']->data->fullName;
            $comment = $mod['comment'];
            $avatar = UPLOAD_URL . 'avatar/170px/' . $mod['user']->data->avatar;
            require $views;
        }
    }
}
?>
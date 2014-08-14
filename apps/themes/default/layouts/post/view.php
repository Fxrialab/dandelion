<?php
$activities = F3::get('activities');
if (!empty($activities))
{
    $rand = rand(100, 100000);
    foreach ($activities as $mod)
    {
        foreach (glob(UI . 'layouts/post/viewPost.php') as $views)
        {
            $status = $mod["status"];
            $like = $mod['like'];
            $statusID = $mod['status']->recordID;
            $activity = $mod['status']->data;
            $userID = $mod['user']->recordID;
            $username = $mod['user']->data->username;
            $avatar = $mod['user']->data->profilePic;
            if ($avatar == 'none')
            {
                $gender = ElementController::findGender($userID);
                if ($gender == 'male')
                    $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                else
                    $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
            }else
            {
//                $photo = ElementController::findPhoto($mod['avatar']);
                $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
            }
            require $views;
        }
    }
    ?>
    <script type="text/javascript">
        $(".oembed<?php echo $rand; ?>").oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 400,
                    autoplay: false
                });
        $('.taPostComment').autosize();
    </script>
    <?php
}
?>

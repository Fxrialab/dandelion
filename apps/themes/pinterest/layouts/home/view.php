<?php
if (!empty($activities))
{
    $rand = rand(100, 100000);
    foreach ($activities as $mod)
    {
        foreach (glob(UI.'layouts/post/viewPost.php') as $views)
        {
            $status = $mod["actions"];
            $username = $mod['username'];
            $avatar = $mod['avatar'];
            $like = $mod['like'];
            $statusID = $mod['statusID'];
            $activity = $mod['actions']->data;
            $userID = $mod['userID']->recordID;
            if ($mod['avatar'] == 'none')
            {
                $gender = ElementController::findGender($userID);
                if ($gender == 'male')
                    $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                else
                    $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
            }else
            {
                $photo = ElementController::findPhoto($mod['avatar']);
                $avatar = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
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

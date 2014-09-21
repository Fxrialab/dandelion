<?php
if (!empty($activities))
{
    $rand = rand(100, 100000);
    foreach ($activities as $mod)
    {
        foreach (glob(MODULES . $mod['type'] . '/views/'.TEMPLATE.'/mains/viewMod.php') as $views)
        {
            $status     = $mod["actions"];
            $userID     = $mod['user']->recordID;
            $username   = $mod['user']->data->username;
            $profilePic = $mod['user']->data->profilePic;
            $like       = $mod['like'];
            $objectID   = $mod['objectID'];
            $actorName  = HelperController::getFullNameUser($userID);
            if ($profilePic == 'none')
            {
                $gender = HelperController::findGender($userID);
                if ($gender == 'male')
                    $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                else
                    $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
            }else
            {
                $photo = HelperController::findPhoto($profilePic);
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

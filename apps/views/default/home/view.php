<?php
if (!empty($activities))
{
    $rand = rand(100, 100000);
    foreach ($activities as $mod)
    {
        foreach (glob(MODULES . $mod['type'] . '/views/default/viewPost.php') as $views)
        {
            $status     = $mod["actions"];
            $username   = $mod['username'];
            $avatar     = $mod['avatar'];
            $like       = $mod['like'];
            $statusID   = $mod['statusID'];
            $activity   = $mod['actions']->data;
            //$curUserID  = $mod['currentUser']->recordID;
            if ($mod['avatar'] == 'none')
                //check man or woman later
                $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
            else {
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

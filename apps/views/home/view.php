<?php
$activities = $this->f3->get('activities');
$page = $this->f3->get('page');
if (!empty($activities))
{
    $rand = rand(100, 100000);
    foreach ($activities as $mod)
    {
        foreach (glob(MODULES . $mod['type'] . '/views/viewMod.php') as $views)
        {
            $photo = $mod["photo"];
            $status = $mod["actions"];
            $userID = $mod['user']->recordID;
            $username = $mod['user']->data->username;
            $like = $mod['like'];
            $actorName = $mod['user']->data->fullName;
            $comment = $mod['comment'];
            $profilePic = $mod['user']->data->profilePic;
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

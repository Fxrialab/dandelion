<?php
if (!empty($page))
    $p = $page;
else
    $p = '';
$activities = $this->f3->get('activities');
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
            $avatar = UPLOAD_URL . 'avatar/170px/' . $mod['user']->data->avatar;
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

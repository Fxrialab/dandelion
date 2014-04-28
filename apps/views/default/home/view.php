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
    </script>
<?php
}
?>

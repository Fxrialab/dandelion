<?php
if (!empty($activities))
{
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
            //$statusID   = str_replace(":", "_", $mod['actions']->recordID);
            require $views;
        }
    }
}
?>

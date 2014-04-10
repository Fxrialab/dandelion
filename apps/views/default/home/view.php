<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($activities)) {
    foreach ($activities as $mod) {
        foreach (glob(MODULES . $mod['type'] . '/views/default/viewPost.php') as $views) {
            $status = $mod["actions"];
            $username = $mod['username'];
            $avatar = $mod['avatar'];
            $like = $mod['like'];
            $statusID = $mod['statusID'];
            $rpStatusID = str_replace(":", "_", $statusID);
            $activity = $mod['actions']->data;
            $statusID = str_replace(":", "_", $mod['actions']->recordID);
            require $views;
        }
    }
}
?>

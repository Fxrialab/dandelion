<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!empty($activities)) {
    foreach ($activities as $mod) {
            foreach(glob(MODULES.$mod['type'].'/views/default/viewPost.php') as $views){
            require $views;
        }
    }
}
?>

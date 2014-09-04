<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 11:14 AM
 * Project: joinShare Network - Version: 1.0
 */
$activities = F3::get('homes');
if($activities){
    foreach($activities  as $mod){
        foreach(glob(MODULES.$mod['path'].'home.php') as $views){
            F3::set('homeViews',$mod);
            require $views;
        }
    }
}
?>
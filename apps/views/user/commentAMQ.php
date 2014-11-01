<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 3:05 PM
 * Project: joinShare Network - Version: 1.0
 */
$commentAmq = F3::get('commentAmq');
if($commentAmq){
    foreach($commentAmq  as $mod){

        foreach(glob(MODULES.$mod['path'].'comment.php') as $views){
            F3::set('commentHome',$mod);
            require $views;
        }
    }
}

?>
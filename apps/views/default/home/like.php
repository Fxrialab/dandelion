<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!empty($like))
    echo '<a href="javascript:void(0)" onclick="unlike('.$statusID.','.$actor.')">UnLike</a>'; 
else
    echo '<a href="javascript:void(0)" onclick="like('.$statusID.','.$actor.')">Like</a>';
?>


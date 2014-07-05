<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

    <?php
    if ($this->f3->get('groupMember') != 'null')
    {
        foreach ($this->f3->get('groupMember') as $key => $value)
        {
            $f3 = require('viewGroup.php');
        }
    }
    ?>
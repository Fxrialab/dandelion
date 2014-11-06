

<?php

$group = $this->f3->get('group');

if (!empty($group))
{
    foreach ($group as $key => $value)
    {
        $data = $value['group'];
        $f3 = require('viewGroup.php');
    }
}
?>
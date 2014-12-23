<?php

$records = $this->f3->get('comment');

if (!empty($records))
{
    foreach ($records as $value)
    {
        $id = str_replace(":", "_", $value['comment']->recordID);
        $recordID = $value['comment']->recordID;
        $content = $value['comment']->data->content;
        $published = $value['comment']->data->published;
        $numberLike = $value['comment']->data->numberLike;
        $like = $value['like'];
        $profile = $value['user'];
        $f3 = require('item.php');
    }
}
?>
<?php

$records = $this->f3->get('comment');

if (!empty($records))
{
    $id = str_replace(":", "_", $records['comment']->recordID);
    $recordID = $records['comment']->recordID;
    $content = $records['comment']->data->content;
    $published = $records['comment']->data->published;
    $numberLike = $records['comment']->data->numberLike;
    $like = $records['like'];
    $profile = $records['user'];
    $f3 = require('item.php');
}
?>
<?php

if (!empty($mod['comment']))
    $records = $mod['comment'];
else
    $records = $this->f3->get('comment');


if (!empty($records))
{
    if (!empty($records['is_object']))
    {
        $id = str_replace(":", "_", $records['comment']->recordID);
        $recordID = $records['comment']->recordID;
        $content = $records['comment']->data->content;
        $published = $records['comment']->data->published;
        $numberLike = $records['comment']->data->numberLike;
        $like = $records['like'];
        $profile = $records['user'];
        $avatar = UPLOAD_URL . 'avatar/170px/' . $records['avatar'];
        $f3 = require('commentItem.php');
    }
    else
    {
        $pos = (count($records) < 3 ? count($records) : 3);
        for ($j = count($records) - $pos; $j < count($records); $j++)
        {
            $id = str_replace(":", "_", $records[$j]['comment']->recordID);
            $recordID = $records[$j]['comment']->recordID;
            $content = $records[$j]['comment']->data->content;
            $published = $records[$j]['comment']->data->published;
            $numberLike = $records[$j]['comment']->data->numberLike;
            $like = $records[$j]['like'];
            $profile = $records[$j]['user'];
            $avatar = UPLOAD_URL . 'avatar/170px/' . $records[$j]['avatar'];
            $f3 = require('commentItem.php');
        }
    }
}
?>
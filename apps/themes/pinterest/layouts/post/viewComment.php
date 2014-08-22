<?php

$statusID = F3::get('statusID');
if (!empty($statusID))
    $records = PostController::getFindComment($statusID);
else
    $records = F3::get('comments');

if (!empty($records))
{
    if (is_array($records))
    {
        foreach ($records as $value)
        {
            $content = $value->data->content;
            $profile = PostController::getUser(str_replace(":", "_", $value->data->userID));
            $like = PostController::like($value->recordID);
            ViewHtml::render('post/commentItem', array('profile' => $profile, 'content' => $content));
        }
    }
    else
    {
        $profile = PostController::getUser(str_replace(":", "_", $records->data->userID));
        $like = PostController::like($records->recordID);
        ViewHtml::render('post/commentItem', array('profile' => $profile, 'content' => $records->data->content));
    }
}
?>
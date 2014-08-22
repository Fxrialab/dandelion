<?php
$data = F3::get('data');
$user = F3::get('user');
$type = F3::get('type');
$groupMember = F3::get('groupMember');
ViewHtml::render('user/infoBar', array('user' => $user, 'countPost' => F3::get('countPost'), 'countLike' => F3::get('countLike'), 'countGroup' => count($groupMember)));
?>
<div class="container-fluid">
    <div style="display: none;" id="ajax-loader-masonry" class="ajax-loader"></div>
    <div id="masonry">
        <?php
        if (!empty($data))
        {
            foreach ($data as $key => $value)
            {
                ViewHtml::render('post/viewPost', array(
                    'key' => $key,
                    'status' => $value['status'],
                    'image' => $value['image'],
                    'like' => $value['like'],
                    'user' => $value['user'],
                    'comment' => $value['comment']
                ));
            }
        }
        ?>

    </div>
    <div id="navigation">
        <div id="navigation-next"><a href="/user?user=<?php echo $user->data->username ?>&type=<?php echo $type ?>&page=2"></a></div>
    </div>
    <div style="display: none;" id="scrolltotop"><a href="#">Top</a></div>
</div>

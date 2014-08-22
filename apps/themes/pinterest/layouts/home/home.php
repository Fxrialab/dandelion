<?php
$data = F3::get('data');
?>
<div class="container-fluid">
    <div style="display: none;" id="ajax-loader-masonry" class="ajax-loader"></div>
    <div id="masonry">
        <?php
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
        ?>

    </div>
    <div id="navigation">
        <div id="navigation-next"><a href="/home?page=2"></a></div>
    </div>
    <div style="display: none;" id="scrolltotop"><a href="#">Top</a></div>
</div>

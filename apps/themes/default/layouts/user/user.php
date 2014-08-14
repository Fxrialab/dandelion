<?php
// require_once 'coverTimeLine.php';     
$user = F3::get('user');
ViewHtml::render('coverTimeLine', array('user' => $user));
?>
<div class="mainColWrapper">
    <div class="uiMainColProfile large-70">
        <div class="uiMainContainer">
            <?php
            $user = F3::get('user');
            ViewHtml::render('post/formPost', array('type' => 'post'));
            ?>
            <div class="wrapperContainer">
                <div id="container" class="column-group">
                    <?php
                    $data = F3::get('data');
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
                <nav id="page-nav">
                    <a href="/user?user=<?php echo $user->data->username ?>&page=2"></a>
                </nav>
            </div>
        </div>
    </div>
    <!--Other part-->

</div>
<script>
    $(function() {

        var $container = $('#container');

        $container.infinitescroll({
            navSelector: '#page-nav', // selector for the paged navigation
            nextSelector: '#page-nav a', // selector for the NEXT link (to page 2)
            itemSelector: '.post', // selector for all items you'll retrieve
            loading: {
                url: '/user?user=<?php echo $user->data->username ?>',
                finishedMsg: 'No more pages to load.',
                img: 'http://i.imgur.com/6RMhx.gif'
            }
        },
        // trigger Masonry as a callback
        function(newElements) {
            // hide new items while they are loading
            var $newElems = $(newElements).css({opacity: 1});
            // ensure that images load before adding to masonry layout

        }
        );
    });
</script>

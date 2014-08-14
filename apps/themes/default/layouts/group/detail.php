<?php
$group = F3::get('group');
$members = F3::get('member');
$countMember = F3::get('countMember');
?>

<?php $f3 = require('coverPhotoGroup.php'); ?>
<?php $f3 = require('groupBar.php'); ?>
<div class="uiMainColProfile uiMainContainer large-70">
    <?php
    ViewHtml::render('post/formPost', array('type' => 'group', 'typeID' => $group->recordID));
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
            <a href="content/group/groupdetail?id=<?php echo str_replace(":", "_", $group->recordID) ?>&page=2"></a>
        </nav>
    </div>
</div>
<div class="large-30 uiRightCol">
    <?php $f3 = require('rightColGroup.php'); ?>
</div>
<script>

//
//    $(document).ready(function() {
//        $('#contentContainer').scrollPagination({
//            nop: 5, // The number of posts per scroll to be loaded
//            offset: 0, // Initial offset, begins at 0 in this case
//            error: 'No More Posts!', // When the user reaches the end this is the message that is
//            // displayed. You can change this if you want.
//            delay: 500, // When you scroll down the posts will load after a delayed amount of time.
//            // This is mainly for usability concerns. You can alter this as you see fit
//            scroll: true // The main bit, if set to false posts will not load as the user scrolls. 
//                    // but will still load if the user clicks.
//        });
//        $('#typeActivity').html('<input type=hidden id=type name=type value=group >');
//        $('#typeActivityID').html('<input type=hidden id=typeID name=typeID value=<?php echo $group->recordID ?>>');
//    });

    $(function() {

        var $container = $('#container');

        $container.infinitescroll({
            navSelector: '#page-nav', // selector for the paged navigation
            nextSelector: '#page-nav a', // selector for the NEXT link (to page 2)
            itemSelector: '.post', // selector for all items you'll retrieve
            loading: {
                url: 'home',
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
<script id="alertTemplate" type="text/x-jQuery-tmpl">
    <div class="control-group">
    <div class="control">
    <div class="statusDialog">Are you sure you want to remove this cover.</div>
    <div class="footerDialog">
    <div class="float-right">
    <button type="submit" class="ink-button green-button comfirmDialogGroup">Comfirm</button>
    <button class=" closeDialog ink-button ">Cancel</a>
    </div>
    </div>
    </div>
    </div>
</script>
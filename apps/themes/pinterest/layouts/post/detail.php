<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$image = F3::get('image');
$status = F3::get('status');
$comments = F3::get('comments');
$user = F3::get('user');
$data = F3::get('data');
?>
<style>
    .pm-title{
        display: none
    }
    .pm-content{
        background: none !important;
    }
</style>
<div class="column-group">
    <div class="large-75">
        <div class="action" style="   background: none repeat scroll 0 0 #e5e5e5;
             border-bottom: 1px solid #d5d5d5;
             border-radius: 5px 5px 0 0; margin-right: 20px; padding:0 10px">
            <a class="ink-button">Like</a>
        </div>
        <div style="margin-right:20px; background-color: #fff; border-radius:0 0 5px 5px;padding: 10px; margin-bottom: 20px; text-align: center">
            <img src=" <?php echo UPLOAD_URL . $image ?>" style="width:300px; height: 500px">
        </div>
        <div style="margin-right:20px; background-color: #fff; border-radius: 5px; padding: 10px; margin: 0; width: 97.5%" class="post">
            <div class="post-meta">
                <div class="post-meta-avatar"><a href="/content/post?user=">
                        <img alt="" src="" class="avatar photo" style="width:50px; height: 50px"></a></div>
                <div class="post-meta-comment">
                    <span class="post-meta-author">       
                        <a href="/content/post?user="><?php echo $user->data->fullName ?></a>
                    </span> 
                </div>
            </div>
            <div class="post-comment_<?php echo str_replace(":", "_", $status->recordID) ?>">
                <?php
                if (!empty($comments))
                {
                    foreach ($comments as $key => $value)
                    {
                        ?>
                        <div class="post-meta">
                            <div class="post-meta-avatar"><a href="/content/post?user=">
                                    <img alt="" src="" class="avatar photo" style="width:50px; height: 50px"></a></div>
                            <div class="post-meta-comment">
                                <span class="post-meta-author">       
                                    <a href="/content/post?user=">fcsacf</a>
                                </span> 
                                <span class="masonry-meta-content">
                                    <?php echo $value->data->content; ?>
                                </span>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
            <div class="post-meta">
                <div class="post-meta-avatar"><img alt="" src="<?php echo F3::get('SESSION.avatar') ?>" class="avatar avatar-30 photo" style="width:50px; height: 50px"></div>
                <div class="post-meta-comment"> 
                    <form id="fmCommentModal-<?php echo str_replace(':', '_', $status->recordID) ?>" class="ink-form">
                        <input name="postID" type="hidden" value="<?php echo str_replace(':', '_', $status->recordID) ?>" />
                        <textarea style="width:100%" name="comment" class="commentPost submitCommentModal" id="textCommentModal-<?php echo str_replace(':', '_', $status->recordID) ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="large-25">

        <div style="background-color: #fff;  border-radius: 5px; padding: 10px;">
            <div style=" height: 500px; overflow-y: scroll">
                <div id="masonryImage">

                    <?php
                    foreach ($data as $val)
                    {
                        ?>
                        <div  class="post" style="width:55px">
                            <a class="postImage" href="content/photo/detailModal?id=<?php echo $val['id'] ?>" rel="<?php echo $val['id'] ?>"> 
                                <img src="<?php echo UPLOAD_URL . $val['image'] ?>" style="border-radius: 0">
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div style=" position: fixed; top: -8px; right: 100px">
    <a href="javascript:void(0)" onclick="$.pgwModal('close');" class="ink-button" style=" overflow: hidden; width: 40px; height: 40px"><div class="pm-close" style="margin-top: 5px"></div></a>
</div>
<script>
    $('#masonryImage').masonry({
itemSelector: '.post',             isFitWidth: true
        }).css('visibility', 'visible');
    $("body").on('keypress', '.submitCommentModal', function(event) {
    var code = (event.keyCode ? event.keyCode : event.which);
        if (code == '13' && !event.shiftKey)
            {
        var statusID = $(this).attr('id').replace('textCommentModal-', '');
            var comment = $("#textCommentModal-" + statusID).val();
        if (comment == '')
                {
                return false;
                } else {
                $.ajax({
                        type: "POST",
                url: "/content/post/postComment",
                data: $('#fmCommentModal-' + statusID).serialize(),
                    cache: false,
                        success: function(html) {
                    $(".post-comment_" + statusID).append(html);
                $("#textCommentModal-" + statusID).val('');

            updateTime();
        }
    });
    //exit();
}
            }
            //return false;
        });

</script>
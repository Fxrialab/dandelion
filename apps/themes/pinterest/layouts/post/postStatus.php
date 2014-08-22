<?php
$content = F3::get('content');
$status = F3::get('status');
?>
<div class="thumb post_<?php echo str_replace(":", "_", $status->recordID) ?>">
    <div class="thumb-holder">
        <div style="display: none;" class="masonry-actionbar">
            <a class="btn btn-mini" href="http://ericulous.com/ipin/2012/08/31/iphone-20//#respond"><i class="icon-comment"></i> Comment</a>
            <a class="btn btn-mini" href="http://ericulous.com/ipin/2012/08/31/iphone-20/">View <i class="icon-arrow-right"></i></a> 
        </div>
        <a href="http://ericulous.com/ipin/2012/08/31/iphone-20/"> <img src="http://dandelion2.local/apps/themes/default/uploads/hinh_0.jpg" alt="<?php echo str_replace(":", "_", $status->recordID) ?>" style="width:220px;">
            <div class="thumbtitle"><?php echo $status->data->content ?></div>
        </a> 
    </div>

    <div class="masonry-meta">
        <div class="masonry-meta-avatar"><img alt="" src="<?php echo UPLOAD_URL ?>a3532e0b26a99b59faa88ae416175c5d.jpg" class="avatar avatar-30 photo" height="30" width="30"></div>
        <div class="masonry-meta-comment"> 
            <textarea style="width: 170px; height: 30px; margin-top: 2px"></textarea>
        </div>
    </div>
</div>
<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 11:05 AM
 * Project: joinShare Network - Version: 1.0
 */
$useID = F3::get('queueAmq');
?>

<script type="text/javascript">

    MQ.queue("socialhub<?php echo $useID; ?>").bind("socialhub<?php echo $useID; ?>", "socialhub<?php echo $useID; ?>").callback(function(m) {
        var commentID;
        var actiID;
        var activity_id =m.data.value;
        console.log(activity_id);
        var type = activity_id.slice(0,1);
        var currentID = $('.currentHome0').val();
        console.log('type: ', type);
        if(type==1){
            var activity = activity_id.slice(1);
            if(currentID==null){
                commentID =0;
                actiID    = activity.slice(currentID.indexOf(':')+1);
            } else {
                commentID = currentID.slice(currentID.indexOf(':')+1);
                actiID    = activity.slice(currentID.indexOf(':')+1);
            }
            if(actiID > commentID){
                $.ajax({
                    type: "POST",
                    url: "/homeAMQ",
                    cache: false,
                    success: function(html){
                        $("ul#swStreamStories").prepend(html);
                    },
                    data: {activity_id:activity }
                });
            }
        }
        if(type==2){
            //alert(activity_id);
            var object = activity_id.slice(1,activity_id.indexOf('-'));
            var idObject = activity_id.slice(activity_id.indexOf('-')+1);
            var Id = idObject.replace(":","_");
            // alert(object);
            $.ajax({
                type: "POST",
                url: "/moreCommentHome",
                cache: false,
                success: function(html){
                    $("#commentBox-"+Id).before(html);
                },
                data: {activity_id:object }
            });
            //$('.swCommentPosted'+Id).remove();
            //$('#showCommentAmq').addClass('.swCommentPosted'+Id);
        }
    });

    $(document).ready(function(){
        $('.swBoxCommment').autosize();
        $('#status').autosize();
        $('#question').autosize();
        $('#txtArea').autosize();
        $(".taggedVideoStatus>a").oembed(null,
            {
                embedMethod: "append",
                maxWidth: 320,
                maxHeight: 240
            });
        $(".oembed5").oembed(null,
            {
                embedMethod: "append",
                maxWidth: 1024,
                maxHeight: 768,
                autoplay: false
            });
    });

</script>
<script type="text/javascript">
    var errorUpload = '<?php echo F3::get('errorUpload');?>';
    if(errorUpload) {
        alert(errorUpload);
    }
</script>
<?php
foreach(glob(MODULES.'*/webroot/js/jshome.php') as $jshome){
    if(file_exists($jshome)){
        require_once ($jshome);
    }
}
?>

<?php AppController::elementModules('postWrap','post'); ?>
<div class="clear"></div>
<div class="clearfix" style="height:1px;"></div>
<div id="pagelet_stream" class="clearfix ">
    <div class="clearfix vertical fixed"></div>
    <div class="swStream">
        <ul id="swStreamStories" class="swList swStream swStream_Content">
            <?php
            $activities = F3::get('homes');
            if($activities){
                foreach($activities  as $mod){
                    foreach(glob(MODULES.$mod['path'].'home.php') as $views){
                        F3::set('homeViews',$mod);
                        require $views;
                    }
                }
            }
            ?>
            <input type="hidden" class="currentHome0" value="" />
        </ul>
        <div id="olderPostBtn">
            <div id="pagelet_stream_pager">
                <div class="clearfix">
                    <a href="" class="moreActivity">More...</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="shareStatus"></div>
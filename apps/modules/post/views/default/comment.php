<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/22/13 - 10:08 AM
 * Project: joinShare Network - Version: 1.0
 */

$rand = rand(1,10000);
$commentHome =  F3::get('commentHome');

if ($commentHome)
{
    $actorName  = $commentHome['name'];
    $actorID    = $commentHome['actor'];
    $actorTagged= $commentHome['tagged'];
    $commentContent = $commentHome['contentCmt'];
    $pfCommentActor = $commentHome['pfCommentActor'];
    $published  = $commentHome['published'];
?>


<div class="swCommentPosted">
    <script type="text/javascript">
        $(document).ready(function(){
            $(".oembed" + <?php echo $rand ?>).oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 768,
                    autoplay: false
                });
        })
    </script>
    <div class="swImg">
        <img class="swCommentImg" src="<?php echo F3::get('BASE_URL'); ?><?php echo $pfCommentActor[$actorID]->data->profilePic; ?>" />
    </div>
    <div>
        <a href="/profile?id=<?php echo $actorID?>"><?php echo $actorName;?></a>
        <label class="swPostedCommment">
            <?php    if($actorTagged =='none'){?>
                <div><?php echo $commentContent; ?></div>
            <?php } else {  ?>
                <div>
                    <?php echo substr($commentContent,0,strpos($commentContent,'_linkWith_')); ?>
                    <a href="<?php echo $actorTagged; ?>"><?php echo $actorTagged; ?></a>
                    <?php echo substr($commentContent,strpos($commentContent,'_linkWith_')+10); ?>
                    <a href='<?php echo $actorTagged; ?>' class='oembed<?php echo $rand ?>' > </a>

                </div>
            <?php } ?>
            <div id= "showCommentAmq"> </div>
        </label>
        <label class="swTimeComment" title="<?php echo $published; ?>"></label>
    </div>
</div>
<?php }    ?>
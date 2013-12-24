<?php 
$content    = $this->f3->get('content');
$published  = $this->f3->get('published');
$currentUser= $this->f3->get('currentUser');
$authorName = ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);
$username   = $currentUser->data->username;
$photoID    = $this->f3->get('postID');
$tagged     = $this->f3->get('tagged');
$rand       = rand(1,10000);
?>
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
<div class="commentContentWrapper">
    <div class="eachCommentItem verGapBox column-group">
        <div class="large-10 uiActorCommentPicCol">
            <a href=""><img src="<?php echo $currentUser->data->profilePic; ?>"></a>
        </div>
        <div class="large-85 uiCommentContent">
            <p>
                <a class="timeLineCommentLink" href="/content/myPost?username=<?php echo $username; ?>"><?php echo $authorName; ?></a>
                <?php
                if($tagged =='none')
                {
                ?>
                    <span class="textComment"><?php echo $content; ?></span>
                <?php
                } else {
                ?>
                    <span class="textComment">
                        <?php echo substr($content,0,strpos($content,'_linkWith_')); ?>
                        <a href="<?php echo $tagged; ?>"><?php echo $tagged; ?></a>
                        <?php echo substr($content,strpos($content,'_linkWith_')+10); ?>
                        <a href='<?php echo $tagged; ?>' class='oembed<?php echo $rand ?>' ></a>
                    </span>
                <?php
                }
                ?>
            </p>
            <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
        </div>
    </div>
</div>
<?php 
$content    = F3::get('content');
$published  = F3::get('published');
$currentUser= F3::get('currentUser');
$authorName = ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);
$authorID   = substr($currentUser->recordID, strpos($currentUser->recordID, ":") + 1);
$photoID    = F3::get('postID');
$tagged     = F3::get('tagged');
$rand = rand(1,10000);
?>

<div class="swCommentPosted <?php echo str_replace(':', '_', $photoID) ?>">
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
		<img class="swCommentImg" src="<?php echo F3::get('BASE_URL'); ?><?php echo $currentUser->data->profilePic; ?>" />
	</div>
	<div>
		<a href="/profile?id=<?php echo $authorID?>"><?php echo $authorName;?></a>
		<label class="swPostedCommment">
            <?php
            if($tagged =='none')
            {?>
            <div><?php echo $content; ?></div>
            <?php
            } else {  ?>
                <div>
                    <?php echo substr($content,0,strpos($content,'_linkWith_')); ?>
                    <a href="<?php echo $tagged; ?>"><?php echo $tagged; ?></a>
                    <?php echo substr($content,strpos($content,'_linkWith_')+10); ?>
                    <a href='<?php echo $tagged; ?>' class='oembed<?php echo $rand ?>' ></a>
                </div>
            <?php
            } ?>
            <div id= "showCommentAmq"> </div>
        </label>
		<label class="swTimeComment" title="<?php echo $published; ?>"></label>
	</div>
</div>
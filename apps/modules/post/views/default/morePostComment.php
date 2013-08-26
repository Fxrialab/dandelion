<?php
$rand           = rand(100,100000);
$records        = F3::get('comments');
$commentActor   = F3::get('commentActor');

if (!empty($records)) {
	$pos = (count($records) < 50 ? count($records) : 50);
	// render comments
	for($j = $pos - 1; $j >=0; $j--)
    {
        $user = $commentActor[$records[$j]->data->actor];
        ?>
		<div class="swCommentPosted">
			<div class="swImg">			
				<img class="swCommentImg" src="<?php echo F3::get('BASE_URL'); ?><?php echo $user->data->profilePic; ?>" />
			</div>
			<div>
				<?php								
					$actorID =  substr( $records[$j]->data->actor, strpos($records[$j]->data->actor, ":") + 1);
					?>
				<a href="/profile?id=<?php echo $actorID;?>"><?php echo $records[$j]->data->actor_name?></a>
                <label class="swPostedCommment">
                    <?php    if($records[$j]->data->tagged =='none'){?>
                    <div><?php echo $records[$j]->data->content; ?></div>
                    <?php } else {  ?>
                    <div>
                        <?php echo substr($records[$j]->data->content,0,strpos($records[$j]->data->content,'_linkWith_')); ?>
                        <a href="<?php echo $records[$j]->data->tagged; ?>"><?php echo $records[$j]->data->tagged; ?></a>
                        <?php echo substr($records[$j]->data->content,strpos($records[$j]->data->content,'_linkWith_')+10); ?>
                        <a href="<?php echo $records[$j]->data->tagged; ?>" class="oembed<?php echo $rand ?>"> </a>
                    </div>
                    <?php } ?>
                </label>
                            <label class="swTimeComment" title="<?php echo $records[$j]->data->published; ?>">via web</label>
			</div>
		</div>
	<?php } // end for
}// end  (!empty($records))?>

<script type="text/javascript">
    $(document).ready(function(){

        var rand =  Math.random().toString();
        var oembedChar = rand.substr(2);
        $(".oembed"+ <?php echo $rand ?>).oembed(null,
            {
                embedMethod: "append",
                maxWidth: 1024,
                maxHeight: 768,
                autoplay: false
            });
    })
</script>
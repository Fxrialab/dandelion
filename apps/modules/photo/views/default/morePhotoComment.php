<?php
$records    = F3::get('comments');
$commentActor= F3::get('commentActor');

if (!empty($records))
{
    $pos    = (count($records) < 50 ? count($records) : 50);
    // render comments
    for($j  = $pos - 1; $j >=0; $j--)
    {
        $user = $commentActor[$records[$j]->data->actor];
        ?>
    <div class="swCommentPostedPhoto">
        <div class="swImg">
            <img class="swCommentImg" src="<?php echo $user->data->profilePic; ?>" />
        </div>
        <div>
            <?php
            $actorID =  substr( $records[$j]->data->actor, strpos($records[$j]->data->actor, ":") + 1);
            ?>
            <a href="/profile?id=<?php echo $actorID;?>"><?php echo $records[$j]->data->actor_name?></a>
            <label class="swPostedCommment"><?php echo $records[$j]->data->content; ?></label>
            <label class="swTimeComment" title="<?php echo $records[$j]->data->published; ?>">via web</label>
        </div>
    </div>
    <?php
    } // end for
}// end  (!empty($records))
?>
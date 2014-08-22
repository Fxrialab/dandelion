<?php
$records    = $this->f3->get('comments');
$commentActor= $this->f3->get('commentActor');

if (!empty($records))
{
    $pos    = (count($records) < 50 ? count($records) : 50);
    // render comments
    for($j  = $pos - 1; $j >=0; $j--)
    {
        $user = $commentActor[$records[$j]->data->actor];
        $published  = $records[$j]->data->published;
        $content    = $records[$j]->data->content;
        $actorComment = ucfirst($user->data->firstName).' '.ucfirst($user->data->lastName);
    ?>
        <div class="eachCommentItem verGapBox column-group">
            <div class="large-20 uiActorCommentPicCol">
                <a href=""><img src="<?php echo $user->data->profilePic; ?>"></a>
            </div>
            <div class="large-80 uiCommentContent">
                <p>
                    <a class="timeLineCommentLink" href="/content/myPost?username=<?php $user->data->username; ?>"><?php echo $actorComment; ?></a>
                    <span class="textComment"><?php echo $content; ?></span>
                </p>
                <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
            </div>
        </div>
    <?php
    } // end for
}// end  (!empty($records))
?>
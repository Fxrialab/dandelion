<?php
$records = $this->f3->get('comments');
if (!empty($records))
{
    for ($j = 0; $j < count($records)- 3; $j++)
    {
        $content    = $records[$j]->data->content;
        $published  = $records[$j]->data->published;
        $profile    = PostController::getUser(str_replace(":", "_", $records[$j]->data->actor));
        $actorComment = ucfirst($profile->data->firstName)." ".ucfirst($profile->data->lastName);
        ?>
        <div class="eachCommentItem verGapBox column-group">
            <div class="large-10 uiActorCommentPicCol">
                <a href="/content/post?user=<?php echo $profile->data->username; ?>"><img src="<?php echo $profile->data->profilePic; ?>"></a>
            </div>
            <div class="large-85 uiCommentContent">
                <p>
                    <a class="timeLineCommentLink" href="/content/post?user=<?php echo $profile->data->username; ?>"><?php echo $actorComment; ?></a>

                        <span class="textComment"><?php echo $content; ?></span>
                </p>
                <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
            </div>
        </div>
        <?php
    }
}
?>
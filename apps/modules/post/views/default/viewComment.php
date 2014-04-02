<?php
if (!empty($statusID))
    $records = PostController::getFindComment($statusID);
else
    $records = $this->f3->get('comments');

if (!empty($records)) {
    ?>
    <div class="commentContentWrapper">
        <?php
        $pos = (count($records) < 3 ? count($records) : 3);
        for ($j = $pos - 1; $j >= 0; $j--) {
            $actorComment = $records[$j]->data->actor_name;
            $tagged = $records[$j]->data->tagged;
            $content = $records[$j]->data->content;
            $published = $records[$j]->data->published;
            $profile = PostController::getUser(str_replace(":", "_", $records[$j]->data->actor));
            ?>
            <div class="eachCommentItem verGapBox column-group">
                <div class="large-10 uiActorCommentPicCol">
                    <a href="/content/myPost?username=<?php echo $profile->data->username; ?>"><img src="<?php echo $profile->data->profilePic; ?>"></a>
                </div>
                <div class="large-85 uiCommentContent">
                    <p>
                        <a class="timeLineCommentLink" href="/content/myPost?username=<?php echo $profile->data->username; ?>"><?php echo $actorComment; ?></a>
                        <?php
                        if ($tagged == 'none') {
                            ?>
                            <span class="textComment"><?php echo $content; ?></span>
                            <?php
                        } else {
                            ?>
                            <span class="textComment">
                                <?php echo substr($content, 0, strpos($content, '_linkWith_')); ?>
                                <a href="<?php echo $tagged; ?>"><?php echo $tagged; ?></a>
                                <?php echo substr($content, strpos($content, '_linkWith_') + 10); ?>
                                <a href="<?php echo $tagged; ?>" class="oembed5"> </a>
                            </span>
                            <?php
                        }
                        ?>
                    </p>
                    <span><a class="linkColor-999999 swTimeComment" name="<?php echo $published; ?>"></a></span>
                </div>
            </div>
            <?php
        } // end for
        ?>
    </div>
    <?php
}
?>

<?php
$records = $this->f3->get('comments');
if (!empty($records)) {
    foreach ($records as $value) {
        ?>
   
            <?php
            $profile = PostController::getUser(str_replace(":", "_", $value->data->actor));
            ?>
            <div class="eachCommentItem verGapBox column-group">
                <div class="large-10 uiActorCommentPicCol">
                    <a href="/content/myPost?username=<?php echo $profile->data->username; ?>"><img src="<?php echo $profile->data->profilePic; ?>"></a>
                </div>
                <div class="large-85 uiCommentContent">
                    <p>
                        <a class="timeLineCommentLink" href="/content/myPost?username=<?php echo $profile->data->username; ?>"><?php echo $profile->data->fullName; ?></a>
          
                            <span class="textComment"><?php echo $value->data->content; ?></span>
                    </p>
                    <span><a class="linkColor-999999 swTimeComment" name="<?php echo $value->data->published; ?>"></a></span>
                </div>
            </div>
        <?php
    }
}
?>
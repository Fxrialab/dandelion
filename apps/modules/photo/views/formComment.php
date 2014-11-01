
<form class="ink-form" id="formcm_<?php echo $uni ?>">
    <fieldset>
        <div class="control-group">
            <div class="control">
                <input name="photoID" type="hidden" id="<?php echo $uni ?>" value="<?php echo $photoID; ?>" />
                <textarea style="min-height: 30px; font-size: 12px;" name="comment" class="commentPhoto" id="comment_<?php echo $uni; ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
            </div>
        </div>
    </fieldset>
</form>
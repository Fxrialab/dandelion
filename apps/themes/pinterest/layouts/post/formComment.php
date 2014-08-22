<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$id = F3::get('id');
?>
<div class="post-meta" style="border-bottom: none">
    <div class="post-meta-avatar"><img alt="" src="<?php echo F3::get('SESSION.avatar') ?>" class="avatar avatar-30 photo" height="30" width="30"></div>
    <div class="post-meta-comment"> 
        <form id="fmComment-<?php echo $id ?>" class="ink-form">
            <input name="postID" type="hidden" value="<?php echo $id ?>" />
            <textarea name="comment" class="commentPost submitComment" id="textComment-<?php echo $id ?>" spellcheck="false" placeholder="Write a comment..."></textarea>
        </form>
    </div>
</div>
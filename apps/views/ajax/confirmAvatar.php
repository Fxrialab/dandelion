<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$image = $this->f3->get('image');
$target = $this->f3->get('target');
?>
<form id="submitAvatar">
    <img src="<?php echo UPLOAD_URL . 'thumbnail/' . $image['name']; ?>">
    <input type="hidden" name="fileName" value="<?php echo $image['name'] ?>">
    <input type="hidden" name="width" value="<?php echo $image['width']; ?>">
    <input type="hidden" name="height" value="<?php echo $image['height']; ?>">
    <input type="hidden" name="target" value="<?php echo $target; ?>">
    <input type="hidden" name="chooseBy" value="avatar">
    <input type="hidden" name="dragX" value="0">
    <input type="hidden" name="dragY" value="0">
    <div class="actionAvatar">
        <button type="button" class="ink-button cancel" id="profilePic">Cancel</button>
        <button type="submit" class="ink-button green-button">Save</button>
    </div>
</form>

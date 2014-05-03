<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form class="ink-form formGroup" id="formRemoveGroup">
    <div class="control-group">
        <div class="control" id="successRemoveGroup">

        </div>
    </div>
    <div class="control-group float-right" >
        <input type="hidden" name="groupID" value="<?php echo $group->recordID ?>">
        <button type="submit" class="ink-button">Comfirm</button>
        <a class="modal_close ink-button red">Cancel</a>
    </div>
</form>
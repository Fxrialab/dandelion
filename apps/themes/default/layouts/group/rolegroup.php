<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$user = $this->f3->get('user');
$group = $this->f3->get('group');
$message = $this->f3->get('message');
?>
<form class="ink-form" id="formRoleGroup">
    <div class="control-group">
        <div class="control" id="successAdmin">
            <div class="statusDialog"><?php echo $message ?></div>
        </div>
    </div>
    <div class=" footerDialog" >
        <input type="hidden" name="groupID" value="<?php echo $group->recordID ?>">
        <input type="hidden" name="userID" value="<?php echo $user->recordID ?>">
        <button type="submit" class="ink-button green-button"><?php echo $this->f3->get('button'); ?></button>
        <button class="closeDialog ink-button">Cancel</button>
    </div>
</form>
<script>
    $(function() {
        $("#formRoleGroup").submit(function() {
            $.ajax({
                type: "POST",
                url: "/content/group/ajax/comfirmrole",
                data: $("#formRoleGroup").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        window.location.href = '/content/group/members?id=' + obj.groupID;
                    } else
                        $("#successAdmin").html('Error');
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    });
</script>
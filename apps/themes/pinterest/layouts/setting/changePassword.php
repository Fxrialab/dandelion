<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form class="ink-form" id="changePassword" style="padding: 10px 0">
    <div class="control-group alert"></div>
    <div class="control-group">
        <label for="name" class="large-30 align-right">Email </label>
        <div class="control large-70">
            <input type="text" name="email">
        </div>
    </div>
    <div class="control-group column-group">
        <label for="name" class="large-30 align-right">New Password</label>
        <div class="control large-70">
            <input type="password" name="newPassword">
        </div>
    </div>
    <div class="control-group column-group">
        <label for="name" class="large-30 align-right">New Password, Again</label>
        <div class="control large-70">
            <input type="password" name="againPassword">
        </div>
    </div>
    <div class="control-group column-group">
        <input type="submit" value="Change Password" class="ink-button red" style="float: right">
        <input type="button" value="Cancel" class="ink-button" onclick="$.pgwModal('close');" style="float: right">
    </div>
</form>
<script type="text/javascript">
            $("#changePassword").submit(function() {
                $.ajax({
                    type: "POST",
                    url: '/changePassword',
                    data: $("#changePassword").serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        if (data == 1) {
                            $('.alert').html('<div class="ink-alert basic success">Process completed successfully</div>');
                        } else {
                            $('.alert').html('<div class="ink-alert basic success">Error: The system has failed</div>');
                        }

                    }
                });

                return false; // avoid to execute the actual submit of the form.
            });
</script>
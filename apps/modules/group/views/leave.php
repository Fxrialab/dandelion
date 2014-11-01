<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form class="ink-form" id="submitLeave">
    <div class="control-group column-group ">
        <div class="statusDialog">Would you like to leave this group or just turn off notifications for new posts?</div>
        <input type="hidden" name="groupID" value="<?php echo $this->f3->get('groupID'); ?>">
        <input type="hidden" name="action" value="ok">
    </div>
    <div class="error"></div>
    <div class="footerDialog" >
        <button type="submit" id="submitLeave" class="ink-button green-button">Leave Group</button>
        <button type="submit" class="ink-button">Turn Off Notifications</button>
    </div>
</form>
<script>
    $(function() {

        $("#submitLeave").submit(function() {
            $.ajax({
                type: "POST",
                url: "/content/group/leave",
                data: $("#submitLeave").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    var obj = jQuery.parseJSON(data);
                    if (obj.del == 1) {
                        $(".dialog").dialog("close");
                        $("#groupBrowse_" + obj.groupID).remove();
                    } else
                    {
                        $(".error").html('<p>Error</p>');
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    })
</script>
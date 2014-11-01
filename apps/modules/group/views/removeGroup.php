<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$user = $this->f3->get('user');
$group = $this->f3->get('group');
if ($user->recordID == $this->f3->get('SESSION.userID'))
    $name = 'yourself';
else
    $name = $user->data->fullName;
?>

<form class="ink-form" id="formRemoveGroup">
    <div class="control-group">

        <div class="control">
            <div class="statusDialog">Are you sure you want to remove <?php echo $name ?> </div>
        </div>

    </div>
    <input type="hidden" name="groupID" value="<?php echo $group->recordID ?>">
    <input type="hidden" name="userID" value="<?php echo $user->recordID ?>">
    <div class="footerDialog" >
        <button type="submit" class="ink-button green-button comfirm">Comfirm</button>
        <button class=" closeDialog ink-button ">Cancel</a>
    </div>
</form>
<script>
    $(function() {
        $("#formRemoveGroup").submit(function() {
            $.ajax({
                type: "POST",
                url: "/content/group/ajax/comfirmRemoveGrorup",
                data: $("#formRemoveGroup").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('#user_' + obj.userID).remove();
                        $(".dialog").dialog("close");
//                        window.location.href = '/content/group/members?id=' + obj.groupID;
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    })
</script>
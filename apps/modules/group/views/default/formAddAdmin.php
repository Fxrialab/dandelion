<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form class="ink-form formGroup" id="formMakeAdmin">
    <div class="control-group">
        <div class="control" id="successAdmin">

        </div>
    </div>
    <div class="control-group float-right" >
        <input type="hidden" name="groupID" value="<?php echo $group->recordID ?>">
        <button type="submit" class="ink-button">Make Admin</button>
        <a class="modal_close ink-button red">Cancel</a>
    </div>
</form>
<script>
    $(function() {

        $("#formMakeAdmin").submit(function() {
            $.ajax({
                type: "POST",
                url: "/content/group/makeAdmin",
                data: $("#formMakeAdmin").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data == 1) {
                        $("#modalMember").css({"display": "none"});
                        $("#lean_overlay").fadeOut(200);
                    } else
                        $("#successAdmin").html('Error');
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    });
</script>

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="large-100 nameForm">
    <form class="ink-form formAbout" id="submitName">
        <div class="error"></div>
        <div class="control-group column-group ">
            <label for="firstName" class="large-30 align-right">First Name</label>
            <div class="control large-70">
                <input type="text" id="firstName" name="firstName" class="large-100" value="<?php echo $firstName ?>">
            </div>
        </div>
        <div class="control-group column-group ">
            <label for="lastName" class="large-30 align-right">Last Name</label>
            <div class="control large-70">
                <input type="text" id="lastName" name="lastName" class="large-100" value="<?php echo $lastName ?>">
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelFormName">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitName").submit(function() {
            $.ajax({
                type: "POST",
                url: "/editname",
                data: $("#submitName").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.nameForm').remove();
                        $('.editname .divname').html(obj.fullName);
                        $(".editname div").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });

    });
</script>
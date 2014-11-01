<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$information = F3::get('information');
?>
<div class="large-100 formGender">
    <form class="ink-form formAbout" id="submitGender">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group ">
            <label for="phone_mobile" class="large-30 align-right">Gender</label>
            <div class="control large-30">
                <select id="Gender" name="gender">
                    <option <?php echo $information->data->gender == 'female' ? "selected" : "" ?> value="female">Female</option>
                    <option <?php echo $information->data->gender == 'male' ? "selected" : "" ?> value="male">Male</option>
                </select>
            </div>

            <div class="control-group column-group">
                <div class="large-30"></div>
                <div class="control large-25">
                    <input type="submit" value="Save Change">
                </div>
                <div class="large-5"></div>
                <div class="control large-20">
                    <input type="button" value="Cancel" class="cancelForm" rel="gender">
                </div>
            </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitGender").submit(function() {
            $.ajax({
                type: "POST",
                url: "/gender",
                data: $("#submitGender").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.formGender').remove();
                        $('.gender .large-60').html(obj.gender);
                        $(".gender div").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });

    });
</script>
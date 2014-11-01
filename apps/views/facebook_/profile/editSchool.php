<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$location = F3::get('location');
$information = F3::get('information');
?>
<div class="large-100 schoolForm">
    <form class="ink-form formAbout" id="submitFormSchool">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group ">
            <label for="school" class="large-30 align-right">School</label>
            <div class="control large-70">
                <input type="text" id="university" name="school" class="large-100" value="<?php echo $information->data->school ?>">
            </div>
        </div>
        <div class="control-group column-group ">
            <label for="school_location" class="large-30 align-right">Location school</label>
            <div class="control large-70">
                <input type="text" id="school_location" name="school_location" class="large-100" value="<?php echo $information->data->school_location ?>">
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelAbout" rel="school">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitFormSchool").submit(function() {
            $.ajax({
                type: "POST",
                url: "/school",
                data: $("#submitFormSchool").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.schoolForm').remove();
                        $('.school .location').html(obj.school);
                        $('.school .position').html(obj.school_location);
                        $(".school .position").show();
                        $(".school .option").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
        $("#school").autocomplete({
            source: "/searchInfoUser?act=school"
        });
        $("#school_location").autocomplete({
            source: "/searchLocation"
        });
    });
</script>
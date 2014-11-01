<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$location = F3::get('location');
$information = F3::get('information');
?>
<div class="large-100 collegeForm">
    <form class="ink-form formAbout" id="submitFormCollege">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group ">
            <label for="university" class="large-30 align-right">University</label>
            <div class="control large-70">
                <input type="text" id="university" name="university" class="large-100" placeholder="<?php echo $information->data->university ?>">
            </div>
        </div>
        <div class="control-group column-group ">
            <label for="concentrations" class="large-30 align-right">Concentrations</label>
            <div class="control large-70">
                <input type="text" id="concentrations" name="concentrations" class="large-100" placeholder="<?php echo $information->data->concentrations ?>">
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelAbout" rel="college">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitFormCollege").submit(function() {
            $.ajax({
                type: "POST",
                url: "/college",
                data: $("#submitFormCollege").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.collegeForm').remove();
                        $('.college .location').html(obj.university);
                        $('.college .position').html(obj.concentrations);
                        $(".college .position").show();
                        $(".college .option").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
        $(function() {
            $("#university").autocomplete({
                source: "/searchInfoUser?act=university"
            });

            $("#concentrations").autocomplete({
                source: "/searchInfoUser?act=concentrations"
            });
        });
    });
</script>
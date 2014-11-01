<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$information = F3::get('information');
?>
<div class="large-100 workForm">
    <form class="ink-form formAbout" id="submitFormWork">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group ">
            <label for="position" class="large-30 align-right">Position</label>
            <div class="control large-70">
                <input type="text" id="position" name="position" class="large-100" value="<?php echo $information->data->position ?>">
            </div>
        </div>
        <div class="control-group column-group" id="friends">
            <label for="city" class="large-30 align-right">City</label>
            <div class="control large-70">
                <input type="text" id="city" name="city" class="large-100" placeholder="<?php echo $information->data->work_location ?>">
            </div>

        </div>
        <div class="control-group column-group">
            <label for="description" class="large-30 align-right">Description</label>
            <div class="control large-70">
                <textarea id="work_description" name="work_description"><?php echo $information->data->work_description ?></textarea>
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelAbout" rel="work">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitFormWork").submit(function() {
            $.ajax({
                type: "POST",
                url: "/work",
                data: $("#submitFormWork").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.workForm').remove();
                        $('.position span').html(obj.position);
                        $(".work .position").show();
                        $(".work .option").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    });
</script>

<script>
    $(function() {
        $("#city").autocomplete({
            source: "/searchLocation"
        });
    });
</script>
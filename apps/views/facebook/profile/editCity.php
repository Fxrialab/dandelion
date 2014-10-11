<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$location = F3::get('location');
$name = F3::get('name');
?>
<div class="large-100 <?php echo $name ?>">
    <form class="ink-form formAbout" id="submitCity">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group" id="friends">
            <label for="city" class="large-30 align-right">City</label>
            <div class="control large-70">
                <input type="text" id="<?php echo $name ?>" name="<?php echo $name ?>_city"  class="large-100">
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelAboutCity" rel="<?php echo $name ?>">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitCity").submit(function() {
            $.ajax({
                type: "POST",
                url: "/" +<?php echo $name ?>,
                data: $("#submitCity").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.' +<?php echo $name ?>).remove();
                        $('.position span').html(obj.position);
                        $("." +<?php echo $name ?> + " .position").show();
                        $("." +<?php echo $name ?> + " .option").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
        $(function() {
            $("#city").autocomplete({
                source: "/searchLocation"
            });
        });
    });
</script>
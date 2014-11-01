
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$information = F3::get('information');
?>
<div class="large-100 contactPhoneForm">
    <form class="ink-form formAbout" id="submitContactMobile">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group ">
            <label for="phone_mobile" class="large-30 align-right">Phone Mobile</label>
            <div class="control large-70">
                <input type="text" id="phone_mobile" name="phone_mobile" class="large-100" value="<?php echo $information->data->phone_mobile ?>">
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelAbout" rel="phone_mobile">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitContactMobile").submit(function() {
            $.ajax({
                type: "POST",
                url: "/contactPhone",
                data: $("#submitContactMobile").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.contactPhoneForm').remove();
                        $('.contactPhone .phone').html(obj.phone);
                        $(".contactPhone div").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });

    });
</script>
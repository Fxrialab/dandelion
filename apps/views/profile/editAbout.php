<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$information = F3::get('information');
?>
<div class="large-100 aboutForm">
    <form class="ink-form formAbout" id="submitFormAbout">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group">
            <label for="description" class="large-30 align-right">Detail About</label>
            <div class="control large-70">
                <textarea id="about" name="about"><?php echo $information->data->about ?></textarea>
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelAbout" rel="editabout">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitFormAbout").submit(function() {
            $.ajax({
                type: "POST",
                url: "/editabout",
                data: $("#submitFormAbout").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.aboutForm').remove();
                        $('.editabout div').show();
                        $('.editabout .divabout').html(obj.about);
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    });
</script>

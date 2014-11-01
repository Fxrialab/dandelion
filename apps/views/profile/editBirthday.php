<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$information = F3::get('information');
$birth = explode('-', $information->data->birthday);
?>
<div class="large-100 formBirthday">
    <form class="ink-form formAbout" id="submitBirthday">
        <div class="error"></div>
        <input type="hidden" id="infoID" name="infoID" value="<?php echo $information->recordID ?>">
        <div class="control-group column-group ">
            <label for="phone_mobile" class="large-30 align-right">Birthday</label>
            <div class="control large-30">
                <select id="Month" name="month">
                    <?php
                    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                    for ($i = 0; $i <= 11; $i++)
                    {
                        ?>
                        <option <?php echo $months[$i] == $birth[0] ? "selected" : "" ?> value="<?php echo $months[$i]; ?>"><?php echo $months[$i]; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="large-5"></div>
            <div class="control large-15">
                <select id="day" name="day">
                    <?php
                    for ($i = 1; $i <= 31; $i++)
                    {
                        ?>
                        <option <?php echo $i == $birth[1] ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="large-30"></div>
            <div class="control large-30">
                <select id="year" name="year">
                    <?php
                    for ($i = 2013; $i >= 1905; $i--)
                    {
                        ?>
                        <option <?php echo $i == $birth[2] ? "selected" : "" ?> value="<?php echo $i; ?>"><?php echo $i; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="control-group column-group">
            <div class="large-30"></div>
            <div class="control large-25">
                <input type="submit" value="Save Change">
            </div>
            <div class="large-5"></div>
            <div class="control large-20">
                <input type="button" value="Cancel" class="cancelForm" rel="birthday">
            </div>
        </div>
    </form>


</div>
<script>
    $(function() {
        $("#submitBirthday").submit(function() {
            $.ajax({
                type: "POST",
                url: "/birthday",
                data: $("#submitBirthday").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.formBirthday').remove();
                        $('.birthday .large-60').html(obj.birthday);
                        $(".birthday div").show();
                    }
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });

    });
</script>
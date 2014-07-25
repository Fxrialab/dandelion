<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form id="submitAvatar">
    <a href=""><img src="<?php echo UPLOAD_URL . 'avatar/170px/' . $image['name']; ?>"></a>
    <input type="hidden" name="coverFile" value="<?php echo $image['name'] ?>">
    <input type="hidden" name="width" value="<?php echo $image['width']; ?>">
    <input type="hidden" name="height" value="<?php echo $image['height']; ?>">
    <input type="hidden" name="target" value="<?php echo $target; ?>">
    <input type="hidden" name="chooseBy" value="avatar">
    <input type="hidden" name="dragX" value="0">
    <input type="hidden" name="dragY" value="0">
    <div style=" position: absolute; bottom: 2px; left: 10px" >
        <button type="button" class="ink-button cancel" id="profilePic">Cancel</button>
        <button type="submit" class="ink-button green-button">Save</button>
    </div>
</form>
<script>
    $(function() {
        $("#submitAvatar").submit(function() {
            $.ajax({
                type: "POST",
                url: "/savePhoto",
                data: $("#submitAvatar").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    if (data) {
                        var obj = jQuery.parseJSON(data);
                        $('.infoUser').html(' <img src="' + obj.avatar + '">');
                        $('.green-button').remove();
                        $('.profileInfo .dropdown').css('display', '');
                        $('.profilePic .profileInfo').css('display', 'block');
                    } else {
                        $('.infoUser').html('Error...');
                    }

                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    })

</script>
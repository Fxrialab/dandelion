<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form id="submitAvatar">
    <a href=""><img src="<?php echo UPLOAD_URL . '150/' . $fileName; ?>"></a>
    <input type="hidden" name="avatar" value="<?php echo $fileName ?>">
    <div style=" position: absolute; bottom: 2px; left: 10px" >
        <button type="submit" class="ink-button green-button">Save</button>
    </div>
</form>
<script>
    $(function() {
        $("#submitAvatar").submit(function() {
            $.ajax({
                type: "POST",
                url: "/comfirmphoto",
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
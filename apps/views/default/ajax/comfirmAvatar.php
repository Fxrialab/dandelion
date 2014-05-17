<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="profilePic">
    <form id="submitAvatar">
        <a href=""><img src="<?php echo $url; ?>"></a>
        <input type="hidden" name="avatar" value="<?php echo $url ?>">
        <div style=" position: absolute; bottom: 2px; left: 10px" >
            <button type="submit" class="ink-button green-button">Save</button>
        </div>
    </form>
</div>
<script>
    $(function() {
        $("#submitAvatar").submit(function() {
            $.ajax({
                type: "POST",
                url: "/comfirmphoto",
                data: $("#submitAvatar").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    $('#imgAvatar').html(data);
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    })

</script>
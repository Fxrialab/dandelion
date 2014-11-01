<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$group = $this->f3->get('group');
?>
<form class="ink-form" id="formDescription">
    <div class="control-group">
        <input type="hidden" id="groupID" name="groupID" value="<?php echo $this->f3->get('groupID') ?>">
        <?php
        if (!empty($group))
        {
            ?>
            <textarea type="text" id="groupDescription" name="groupDescription" style="width: 200px"><?php echo $group->data->description ?></textarea>
            <?php
        }
        else
        {
            ?>
            <textarea type="text" id="groupDescription" name="groupDescription" style="width: 200px" placeholder="Post questions, photos, and create events group"></textarea>
        <?php } ?>
    </div>
    <div class="control-group" >
        <button type="submit" class="ink-button green float-left">Save</button>
        <a href="#">Cancel</a>
    </div>
</form>
<script>
    $(function() {

        $("#formDescription").submit(function() {
            $.ajax({
                type: "POST",
                url: "/content/group/editDescription",
                data: $("#formDescription").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    var obj = jQuery.parseJSON(data);
                    $('#groupDescription').html('<p>' + obj.description + '</p><span>You successfully updated!</span>')
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
    })
</script>
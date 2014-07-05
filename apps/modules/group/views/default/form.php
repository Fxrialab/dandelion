
<style>
    .formGroup{
        padding: 10px;
    }

</style>
<form class="ink-form formGroup" id="submitForm">
    <div class="error"></div>
    <div class="control-group column-group ">
        <label for="groupName" class="large-30 align-right">Group Name</label>
        <div class="control large-70">
            <input type="text" id="groupName" name="groupName" class="large-100" style="line-height:22px">
        </div>
    </div>
    <div class="control-group column-group" id="friends">
        <label for="groupMember" class="large-30 align-right">Members</label>
        <div class="control large-70">
            <input type="text" id="groupMember" name="groupMember"  class="large-100">

        </div>
    </div>
    <div class="control-group column-group">
        <label for="groupPrivacy" class="large-30 align-right">Privacy</label>
        <ul class="control unstyled permision large-70">
            <li><input type="radio" id="privacy1" name="groupPrivacy" checked value="open">
                <label for="privacy1"> Open 
                    <p>Anyone can see the group, who's in it, and what members post.</p>
                </label>
            </li>
            <li><input type="radio" id="privacy2" name="groupPrivacy" value="closed"><label for="privacy2">Closed
                    <p>Anyone can see the group and who's in it. Only members see posts</p>
                </label></li>
            <li><input type="radio" id="privacy3" name="groupPrivacy" value="Secret"><label for="privacy3">Secret
                    <p>Only members see the group, who's in it, and what members post.</p></label></li>

        </ul>
    </div>
    <div class="footerDialog" >
        <div class="float-right">
            <button type="submit" id="groupSubmit" class="ink-button green-button">Add</button>
            <button type="button" id="dialogCreateGroup" class="closeDialog ink-button">Cancel</button>
        </div>
    </div>
</form>
<script>
    $(function() {
        $("#submitForm").submit(function() {
            var groupName = $('#groupName').val();
            var groupMember = $('#groupMember').val();
            if (groupName == '') {
                $(".error").html('<div class="ink-alert"><button class="ink-dismiss">×</button><p>Error Group Name</p></div>');
            }
            else if (groupMember == '') {
                $(".error").html('<div class="ink-alert"><button class="ink-dismiss">×</button><p>Error Group Member</p></div>');
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "/content/group/create",
                    data: $("#submitForm").serialize(), // serializes the form's elements.
                    success: function(data)
                    {
                        $(".dialog").dialog("close");
                        $("#viewGroup").prepend(data);
                    }
                });
            }

            return false; // avoid to execute the actual submit of the form.
        });
        $('#groupMember').tokenInput("/content/group/ajax/searchFriends", {
            theme: "facebook",
            method: 'POST',
            queryParam: 'q',
            placeholder: "Add Members",
            hintText: "",
            noResultsText: "Nothin' found.",
            preventDuplicates: true
        });
    });
</script>

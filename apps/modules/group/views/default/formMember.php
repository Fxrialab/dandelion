
<style>
    .formGroup{
        padding: 10px
    }

</style>
<form class="ink-form formGroup" id="formAddMember">
    <div class="control-group" id="friends">
        <div class="control">
            <input type="hidden" id="groupID" name="groupID" value="<?php echo $group->recordID ?>">
            <input type="text" id="groupAddMember" name="groupAddMember">
        </div>
    </div>
    <div id="rsMember"></div>
    <div class="control-group float-right" >
        <button type="submit" id="groupSubmit" class="ink-button green">Add</button>
        <a class="modal_close ink-button red">Cancel</a>
    </div>
</form>
<script>
    $(function() {

        $("#formAddMember").submit(function() {
            $.ajax({
                type: "POST",
                url: "/content/group/addMemberGroup",
                data: $("#formAddMember").serialize(), // serializes the form's elements.
                success: function(html)
                {
                    $('#rsMember').html(html);
                    $('.token-input-token-facebook').remove();
                    $('#friends').remove();
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
        $(function() {
            $('#groupAddMember').tokenInput("/content/group/addmember?groupID=<?php echo str_replace(":", "_", $group->recordID) ?>", {
                theme: "facebook",
                method: 'POST',
                queryParam: 'q',
                hintText: "Search...?",
                noResultsText: "Nothin' found.",
                searchingText: "Gaming...",
                preventDuplicates: true
            });

        });
    });
</script>

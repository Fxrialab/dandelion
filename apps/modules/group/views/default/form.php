
<style>
    .formGroup{
        padding: 10px
    }

</style>
<form class="ink-form formGroup" id="submitForm">
    <div class="control-group column-group">
        <div class="control">
            <input type="text" id="groupName" name="groupName" placeholder="Group Name">
        </div>
    </div>
    <div class="control-group column-group" id="friends">
        <div class="control">
            <input type="text" id="groupMember" name="groupMember" placeholder="Add members">
        </div>
    </div>
    <hr>
    <div class="control-group">
        <label for="groupPrivacy">Privacy</label>
        <ul class="control unstyled">
            <li><input type="radio" id="privacy1" name="groupPrivacy" checked value="open"><label for="privacy1">Open</label></li>
            <li><input type="radio" id="privacy2" name="groupPrivacy" value="closed"><label for="privacy2">Closed</label></li>
            <li><input type="radio" id="privacy3" name="groupPrivacy" value="Secret"><label for="privacy3">Secret</label></li>
        </ul>
    </div>
    <div class="control-group float-right" >
        <button type="submit" id="groupSubmit" class="ink-button green">Add</button>
        <a class="modal_close ink-button red">Cancel</a>
    </div>
</form>
<script>
//    $("a[rel*=leanModal]").leanModal();
    $(function() {
//        $('a[rel*=leanModal]').leanModal({top: 100, closeButton: ".modal_close"});

        $("#submitForm").submit(function() {
            $.ajax({
                type: "POST",
                url: "/content/group/create",
                data: $("#submitForm").serialize(), // serializes the form's elements.
                success: function(html)
                {
                    $("#lean_overlay").fadeOut(200);
                    $("#modalGroup").css({"display": "none"});
                    $("#viewGroup").prepend(html);
                }
            });

            return false; // avoid to execute the actual submit of the form.
        });
        $(function() {
            $('#groupMember').tokenInput("/content/group/addmember", {
                theme: "facebook",
                method: 'POST',
                queryParam: 'q',
                placeholder: "Add Members",
                hintText: "Search members...?",
                noResultsText: "Nothin' found.",
                searchingText: "Gaming...",
                preventDuplicates: true
            });

        });
    });
</script>

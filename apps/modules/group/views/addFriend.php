<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$groupID = $this->f3->get('groupID');
?>
<form class="ink-form" id="addFriend" style="padding: 10px; min-height: 100px">
    <div class="control-group" id="friends">
        <div class="control">
            <input type="hidden" id="groupID" name="groupID" value="<?php echo str_replace("_", ":", $groupID) ?>">
            <input type="text" id="groupAddFriend" name="groupAddFriend">
        </div>
    </div>
    <div id="rsMember">
    </div>
    <div class="footerDialog" >
        <button type="submit" class="ink-button green-button">Add</button>
        <a  class="ink-button" onclick="$.pgwModal('close')">Cancel</a>
    </div>
</form>
<script>
            $(function() {

                $("#addFriend").submit(function() {
                    $.ajax({
                        type: "POST",
                        url: "/content/group/ajax/addMemberGroup",
                        data: $("#addFriend").serialize(), // serializes the form's elements.
                        success: function(data)
                        {
                            $('#rsMember').append(data);
                            $('.token-input-token-facebook').remove();
                            $('#friends').remove();
                        }
                    });

                    return false; // avoid to execute the actual submit of the form.
                });
                $('#groupAddFriend').tokenInput("/content/group/ajax/searchFriends?groupID=<?php echo str_replace(":", "_", $groupID) ?>", {
                    theme: "facebook",
                    method: 'POST',
                    queryParam: 'q',
                    placeholder: "Add Members",
                    hintText: '',
                    noResultsText: "Nothin' found.",
                    searchingText: "Gaming...",
                    preventDuplicates: true
                });

            });
</script>
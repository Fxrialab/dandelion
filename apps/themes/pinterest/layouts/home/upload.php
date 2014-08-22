

<div class="column-group">
    <div class="large-50"><div id="singleFile"><a class="ink-button green">Upload photo</a></div>
    </div>
    <div class="large-50"><div class="msg"></div></div>

    <div style="margin-left: -10px; margin-right: -10px; margin-bottom: -12px" class="display">
        <form style="margin: 0;" class="ink-form" id="formStatus">
            <div style="padding: 10px">
                <div class="column-group">

                    <div class="large-70">
                        <div class="column-group">
                            <label class="large-30">Board</label>
                            <select id="selectBoard" class="large-70" name="typeID">
                                <?php
                                $groupMember = F3::get('groupMember');
                                if (!empty($groupMember))
                                {
                                    foreach ($groupMember as $value)
                                    {
                                        $group = Controller::getID('group', $value->data->groupID);
                                        echo '<option value="' . $value->recordID . '">' . $group->data->name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="column-group">
                            <label class="large-30">Status</label>
                            <textarea id="postStatus" name="status" class="large-70"></textarea>
                            <input type="hidden" name="type" value="post">
                            <input type="hidden" name="embedType" value="photo">
                        </div>
                    </div>
                    <div class="large-30">
                        <div class="image" style="text-align: center">

                        </div>
                    </div>
                </div>
            </div>
            <div style="margin: 0; background:#e5e5e5; padding: 5px 10px; text-align: right">
                <a href="#" class="ink-button">Cancel</a>
                <button class="ink-button" id="submit-post" disabled>Post</button>
            </div>
        </form>

    </div>
    <script>
        $(document).ready(function()
        {
            var settingSingleFile = {
                url: "upload",
                method: "POST",
                allowedTypes: "jpg,png,gif",
                fileName: "myfile",
                multiple: false,
                onBeforeSend: function() {
                    $('.ajax-file-upload-statusbar').hide();
                    $(".msg").html("<div class='loading'></div>");
                },
                onSuccess: function(files, data, xhr)
                {
                    $('.pm-title').html('Description');
                    $('.ajax-upload-dragdrop').remove();
                    $('.loading').remove();
                    $('.display').css('display', 'block');
                    $.each(data.results, function() {
                        $("#imgTemplate").tmpl(data.results).appendTo(".image");
                    });
                    new Hover();
                },
                onError: function(files, status, errMsg)
                {
                    $("#status").html("<font color='red'>Upload is Failed</font>");
                }
            };
            $("#singleFile").uploadFile(settingSingleFile);



        });
        $("body").on('click', '#postStatus', function(e) {
            e.preventDefault();
            document.getElementById("submit-post").disabled = false;
        });
        $("body").on('submit', '#formStatus', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/content/post/postStatus",
                data: $("#formStatus").serialize(), // serializes the form's elements.
                success: function(html)
                {
                    $.pgwModal('close');
                    window.location.href = '<?php echo BASE_URL ?>home';
                    updateTime();
                }
            });
            return false; // avoid to execute the actual submit of the form.
        });
    </script>

    <script id="imgTemplate" type="text/x-jQuery-tmpl">
        <input type="hidden" name="imgID[]" value="${name},${width},${height}">
        <img src="${url}" style="width:100px">
    </script>
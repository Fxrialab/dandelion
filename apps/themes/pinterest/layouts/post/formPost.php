
<?php
$status = F3::get('status');
$user = F3::get('user');
$image = F3::get('image');
$groupMember = F3::get('groupMember');
?>
<div class="column-group">
    <?php
    if (!empty($status))
    {
        $display = '';
    }
    else
    {
        $display = 'display';
        ?>
        <div class="large-50"><div id="singleFile"><a class="ink-button green">Upload photo</a></div>
        </div>
        <div class="large-50"><div class="msg"></div></div>
        <?php
    }
    ?>

    <div style="margin-left: -10px; margin-right: -10px; margin-bottom: -12px" class="<?php echo $display ?>">
        <form style="margin: 0;" class="ink-form" id="formStatus">
            <div style="padding: 10px">
                <div class="column-group">
                    <div class="large-70">
                        <div class="column-group">
                            <label class="large-30">Board</label>
                            <select id="e1" class="large-70" name="typeID">
                                <?php
                                if (!empty($groupMember))
                                {
                                    foreach ($groupMember as $value)
                                    {
                                        if (!empty($status) && $status->data->typeID == $value->recordID)
                                            $selected = 'selected';
                                        else
                                            $selected = '';

                                        $group = Controller::getID('group', $value->data->groupID);
                                        echo '<option value="' . $value->recordID . '" ' . $selected . '>' . $group->data->name . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="column-group">
                            <label class="large-30">Status</label>
                            <textarea id="postStatus" name="status" class="large-70"><?php if (!empty($status)) echo $status->data->content ?></textarea>
                            <input type="hidden" name="type" value="">
                            <input type="hidden" name="embedType" value="photo">
                        </div>
                    </div>
                    <div class="large-30">
                        <div class="image" style="text-align: center">
                            <?php
                            if (!empty($image))
                            {
                                echo '<input type="hidden" name="photoID" value="' . $image->recordID . '">';
                                echo '<img style="width:100px" src="' . UPLOAD_URL . $image->data->fileName . '">';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin: 0; background:#e5e5e5; padding: 5px 10px; text-align: right">
                <a href="javascript:void(0)" onclick="$.pgwModal('close');" class="ink-button">Cancel</a>
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
                                $('#masonry').append(html);
//                                window.location.href = '<?php echo BASE_URL ?>home';
                                $('#masonry').masonry({
                                    itemSelector: '.post',
                                    isFitWidth: true
                                }).css('visibility', 'visible');
                                $('#ajax-loader-masonry').hide();
                                $.pgwModal('close');
                                updateTime();
                            }
                        });
                        return false; // avoid to execute the actual submit of the form.
                    });

                    $(document).ready(function() {
                        $("#e1").select2();

                    });

    </script>
    <script id="imgTemplate" type="text/x-jQuery-tmpl">
        <input type="hidden" name="imgID[]" value="${name},${width},${height}">
        <img src="${url}" style="width:100px">
    </script>
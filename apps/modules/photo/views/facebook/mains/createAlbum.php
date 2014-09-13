<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="dialogContainers">
    <form class="ink-form" id="formAlbum">
        <div class="column-group titleDialog">
            <div class="large-30">
                <input type="text" name="albumTitle" autocomplete="off" placeholder="Untitled Album" class="large-100">
            </div>
            <div class="large-10"></div>
            <div class="large-30">
                <textarea name="albumDescription" cols="3" rows="2" placeholder="Write something about this album" class="large-100"></textarea>
            </div>
            <div class="large-10"></div>
            <div class="large-20">
                <div id="uploadAlbum"> <a class="ink-button green">Upload photo</a></div>
                <div class="msg"></div>
            </div>
        </div>
        <div class="column-group contentDialog">
        </div>
        <div class="footerDialog" >
            <div class="float-right">
                <button type="submit" class="ink-button green-button">Post</button>
                <button type="button" class="closeDialog ink-button">Cancel</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        //$('textarea').autosize();

        var uploadAlbum = {
            url: "/uploading",
            method: "POST",
            allowedTypes: "jpg,png,gif",
            fileName: "myfile",
            multiple: true,
            onBeforeSend: function() {
                $('.ajax-file-upload-statusbar').hide();
                $(".msg").html("<div class='loadingUpload'></div>");
            },
            onSuccess: function(files, data, xhr)
            {
                $(".msg").html("");
                $(".ui-dialog-titlebar").hide();
                $(".ui-dialog-titlebar-close").hide();
                $.each(data.results, function() {
                    $("#imgTemplate4").tmpl(data.results).appendTo(".contentDialog");
                });
            },
            onError: function(files, status, errMsg)
            {
                $(".imgUpload").html("Upload is Failed");
            }
        };
        $("#uploadAlbum").uploadFile(uploadAlbum);

    });
    $("#formAlbum").submit(function() {
        $.ajax({
            type: "POST",
            url: "/content/photo/createAlbum",
            data: $("#formAlbum").serialize(), // serializes the form's elements.
            success: function(data)
            {
                location.replace(data);
            }
        });
        return false; // avoid to execute the actual submit of the form.
    });

</script>
<script id="imgTemplate4" type="text/x-jQuery-tmpl">
    <div class="large-25" style="position: relative">
        <div style="margin-right:20px;">
            <input type="hidden" name="imgName[]" value="${photoName},${nameNotExt}">
            <img src="${url}" style="width:100%">
            <textarea name="description_${nameNotExt}" style="min-height:3px; width:100%"  placeholder="Write something about this photo"></textarea>
            <a href="javascript:void(0)" style="position: absolute; top:5px; right:35px" rel="${photoName}" class="deletePhoto"><span class="icon icon56">X</span></a>
        </div>
    </div>
</script>
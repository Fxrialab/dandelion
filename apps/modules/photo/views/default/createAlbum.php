<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div style="padding: 10px;">
    <form class="ink-form" id="formAlbum">
        <div class="column-group">
            <div class="large-30">
                <input type="text" name="title" placeholder="Enter title" class="large-100">
            </div>
            <div class="large-10"></div>
            <div class="large-30">
                <input type="text" name="description" placeholder="Enter description" class="large-100">
            </div>
            <div class="large-10"></div>
            <div class="large-20">
                <div id="uploadAlbum"> <a class="ink-button green">Upload photo</a></div>
                <div class="msg"></div>
            </div>
        </div>
        <div class="column-group album">
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
        $('textarea').autosize();

        var uploadAlbum = {
            url: "/content/photo/upload",
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
                    $("#imgTemplate4").tmpl(data.results).appendTo(".album");
                });

                new Hover();
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
    <div class="large-25" id="${imgID}" style="position: relative">
    <div style="margin-right:20px;">
    <input type="hidden" name="imgID[]" value="${imgID},${name},${width},${height}">
    <img src="${url}" style="width:100%">
    <textarea name="description_${imgID}" style="min-height:3px; width:100%"  placeholder="Enter description"></textarea>            
    <a href="javascript:void(0)" style="position: absolute; top:5px; right:35px" rel="${name}" relID="${imgID}" class="deletePhoto"><span class="icon icon56">X</span></a>
    </div>
    </div>
</script>